<?php

namespace App\Http\Controllers;

use App\Jobs\SendReminderEmail;
use App\Models\event;
use App\Models\image;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use League\Flysystem\Exception;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use Session;
use ZipArchive;

class HomeController extends Controller
{
    use DispatchesJobs;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth', ['except' => 'email']);
    }

    public function index()
    {
        return view('home');
    }

    public function check($email)
    {
        $res = User::where('email',$email)->first();
        if($res){
            return Response::json(['message' => '此邮箱已注册', 'code' => 401]);
        }else{
            return Response::json(['message' => '可以使用', 'code' => 200]);
        }
    }

    public function setting()
    {
        return view('auth.setting');
    }

    public function settings(Request $request)
    {
        $input = $request->all();
        $id = Auth::user()->id;
        if ($id){
            $user = User::find($id);
            $user->name = $input['name'];
            $user->last_name = $input['last_name'];

            if ($input['password'] === Auth::user()->password) {
                $user->password = $input['password'];
            } else {
                $user->password = bcrypt($input['password']);
            }
            $user->company = $input['company'];
            $user->phone = $input['phone'];
            $user->email = $input['email'];
//            $user->address = $input['address'];
//            $user->number = $input['number'];
//            $user->holder = $input['holder'];
            if ($user->save()) {
                return Response::json(['message' => '修改成功', 'code' => 200]);
            } else {
                return Response::json(['message' => '修改失败', 'code' => 410]);
            }
        }

    }

    public function lists()
    {
        $list['round'] = event::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $list['round_full'] = event::where('user_id', Auth::user()->id)->get();
        return Response::json($list);
    }

    public function move($id)
    {
        $post = event::find($id);
        if ($post->delete()) {
            return Response::json(['message' => '删除成功', 'code' => 200]);
        } else {
            return Response::json(['message' => '删除失败', 'code' => 410]);
        }
    }

    public function move_all(Request $request)
    {
        $str = $request->input('id');
        //$str = explode(",", $g_id);
        foreach ($str as $v) {
            $post = event::find($v);
            $post->delete();
            if ($post->trashed()) {
                return Response::json(['message' => '删除成功', 'code' => 200]);
            } else {
                return Response::json(['message' => '删除失败', 'code' => 410]);
            }
            //$deleted = event::where('id', $v)->delete();
        }
    }

    public function upload()
    {
        return view('upload');
    }

    public function detail($id)
    {
        return view('detail', compact('id'));
    }

    public function details( $id)
    {
        //dowlond s3
        $list['list'] = image::where('event_id', $id)->where('user_id', Auth::user()->id)->with('author')->get();
        foreach ($list['list'] as $value) {
            $fingerprint = explode('.', $value->fingerprint)[0];
            //$content = iconv("utf-8", "gb2312//IGNORE", $value->img_name);
            if (!file_exists(str_replace('\\', '/', public_path()) . '/downloads_xml/' . $fingerprint . '.xml')) {
                $s3 = App::make('aws')->createClient('s3');
                $result = $s3->getObject(array(
                    'Bucket' => 'vmaxx1',
                    'Key' => 'agel/' . $fingerprint . '.xml',
                    'SaveAs' => str_replace('\\', '/', public_path()) . '/downloads_xml/' . $fingerprint . '.xml',
                ));
            }
            $list['list_a'][] = simplexml_load_file(str_replace('\\', '/', public_path()) . '/downloads_xml/' . $fingerprint . '.xml');
        }
        return Response::json($list);
    }

    public function payment(Request $request)
    {
        $input = $request->all();
        // 保存到Session
        $request->session()->put('content', $input);
        $clientId = 'Aa5YDEw9oH1ouRbzK4PGIAlwPJRM8nrRMM5DHOJ6IqpEnv5nlQvFGs7l0Xk8GC0FwdZUH3cXhHnZw9Hc';
        $clientSecret = 'EOWJqNPSdNMYjsobuFVHItSW0BvX7vZ5zX0aAFOOpdcV4W3ph5CiG2vvTbKYXBbtolPFRPexu60RebRH';
        $apiContext = new ApiContext(new OAuthTokenCredential($clientId, $clientSecret));
        $apiContext->setConfig(
            array(
                'mode' => 'sandbox',
                'log.LogEnabled' => true,
                'log.FileName' => '../PayPal.log',
                'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'cache.enabled' => true,
                'http.CURLOPT_CONNECTTIMEOUT' => 30
            )
        );

        if (!isset($input['price'])) {
            die("lose some params");
        }
        $product = 'Welcome to PayPal payment';
        $number = 1;
        $price = $request->session()->get('content')['price'];

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName($product)
            ->setCurrency('USD')
            ->setQuantity($number)
            ->setPrice($price);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details->setSubtotal($price); //值应为 有几个付款项目 数量*价格+第二个付款项目的数量*价格 #####项目金额必须加起来达到指定金额小计

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($price)//值应为 详情的Subtotal值 如果有税必须+税  #####项目金额必须加起来达到指定金额小计
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());
        // 回调地址
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl('http://' . $_SERVER['HTTP_HOST'] . "/exec?success=true")
            ->setCancelUrl('http://' . $_SERVER['HTTP_HOST'] . "/cancel?success=false");

        // 付款
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);
        try {
            $payment->create($apiContext);
            $approvalUrl = $payment->getApprovalLink();
            return Redirect::to($approvalUrl);
        } catch (PayPalConnectionException $e) {
            echo $e->getData();
            die();
        }
    }

    public function exec()
    {
        $clientId = 'Aa5YDEw9oH1ouRbzK4PGIAlwPJRM8nrRMM5DHOJ6IqpEnv5nlQvFGs7l0Xk8GC0FwdZUH3cXhHnZw9Hc';
        $clientSecret = 'EOWJqNPSdNMYjsobuFVHItSW0BvX7vZ5zX0aAFOOpdcV4W3ph5CiG2vvTbKYXBbtolPFRPexu60RebRH';
        $apiContext = new ApiContext(new OAuthTokenCredential($clientId, $clientSecret));
        $apiContext->setConfig(
            array(
                'mode' => 'sandbox',
                'log.LogEnabled' => true,
                'log.FileName' => '../PayPal.log',
                'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'cache.enabled' => true,
                'http.CURLOPT_CONNECTTIMEOUT' => 30
            )
        );
        // 审批状态，确定用户是否批准付款
        if (isset($_GET['success']) && $_GET['success'] == 'true') {

            // 通过传递paymentId获取付款对象
            // payment id was previously stored in session in CreatePaymentUsingPayPal.php
            $paymentId = $_GET['paymentId'];
            $payerId = $_GET['PayerID'];
            $payment = Payment::get($paymentId, $apiContext);

            // 执行付款，PaymentExecution对象包括必要的信息，以执行PayPal帐户支付。将payer_id添加到请求查询参数，当用户被重定向从paypal回到您的网站
            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);

            try {
                // 执行付款
                $result = $payment->execute($execution, $apiContext);
                //echo "支付成功！感谢支持!";
                return redirect('/purchase');
            } catch (Exception $ex) {
                echo "支付失败";
                exit(1);
            }
            //return $payment;
        } else {
            echo "PayPal返回回调地址参数错误";
        }
    }

    public function export(Request $request)
    {
        $checkbox = $request->input('checkbox');
        $id = $request->input('event_id');
        if($checkbox == 'PDF'){
            //download to PDF
            $s3 = App::make('aws')->createClient('s3');
            $result = $s3->getObject(array(
                'Bucket' => 'vmaxx1',
                'Key' => 'agel/' . $id . '.pdf',
                'SaveAs' => str_replace('\\', '/', public_path()) . '/downloads_xml/' . $id . '.pdf',
            ));
            $filename = str_replace('\\', '/', public_path()) . '/downloads_xml/' . $id. '.pdf'; // 最终生成的文件名（含路径）
            header("Cache-Control: max-age=0");
            header("Content-Description: File Transfer");
            header('Content-disposition: attachment; filename=' . basename($filename)); // 文件名
            header("Content-Type: application/pdf"); // zip格式的
            header("Content-Transfer-Encoding: binary"); // 告诉浏览器，这是二进制文件
            header('Content-Length: ' . filesize($filename)); // 告诉浏览器，文件大小
            @readfile($filename);//输出文件;
        }elseif ($checkbox == 'ZIP'){
            //download to ZIP
            $filename = str_replace('\\', '/', public_path()) . '/downloads_xml/' . date('YmdHis') . '.zip'; // 最终生成的文件名（含路径）
            // 生成文件
            $zip = new ZipArchive (); // 使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释
            if ($zip->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
                exit ('无法打开文件，或者文件创建失败');
            }
            $list = image::where('event_id', $id)->where('user_id', Auth::user()->id)->with('author')->get();
            foreach ($list as $key => $value) {
                $fingerprint = explode('.', $value->fingerprint)[0];
                $zip->addFile(str_replace('\\', '/', public_path()) . '/downloads_xml/' . $fingerprint . '.xml', basename($fingerprint . ' --' . ($key+1) . '.xml')); // 第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下
            }
            $zip->close(); // 关闭
            //下面是输出下载;
            header("Cache-Control: max-age=0");
            header("Content-Description: File Transfer");
            header('Content-disposition: attachment; filename=' . basename($filename)); // 文件名
            header("Content-Type: application/zip"); // zip格式的
            header("Content-Transfer-Encoding: binary"); // 告诉浏览器，这是二进制文件
            header('Content-Length: ' . filesize($filename)); // 告诉浏览器，文件大小
            @readfile($filename);//输出文件;
        }else{
            //download to PDF and ZIP
            $s3 = App::make('aws')->createClient('s3');
            $result = $s3->getObject(array(
                'Bucket' => 'vmaxx1',
                'Key' => 'agel/' . $id . '.pdf',
                'SaveAs' => str_replace('\\', '/', public_path()) . '/downloads_xml/' . $id . '.pdf',
            ));

            $filename = str_replace('\\', '/', public_path()) . '/downloads_xml/' . date('YmdHis') . '.zip'; // 最终生成的文件名（含路径）
            // 生成文件
            $zip = new ZipArchive (); // 使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释
            if ($zip->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
                exit ('无法打开文件，或者文件创建失败');
            }
            $list = image::where('event_id', $id)->where('user_id', Auth::user()->id)->with('author')->get();
            foreach ($list as $key => $value) {
                $fingerprint = explode('.', $value->fingerprint)[0];
                $zip->addFile(str_replace('\\', '/', public_path()) . '/downloads_xml/' . $fingerprint . '.xml', basename($fingerprint . ' --' . ($key+1) . '.xml')); // 第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下
                $zip->addFile(str_replace('\\', '/', public_path()) . '/downloads_xml/' . $id . '.pdf', basename( $id . '.pdf')); // 第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下
            }
            $zip->close(); // 关闭
            //下面是输出下载;
            header("Cache-Control: max-age=0");
            header("Content-Description: File Transfer");
            header('Content-disposition: attachment; filename=' . basename($filename)); // 文件名
            header("Content-Type: application/zip"); // zip格式的
            header("Content-Transfer-Encoding: binary"); // 告诉浏览器，这是二进制文件
            header('Content-Length: ' . filesize($filename)); // 告诉浏览器，文件大小
            @readfile($filename);//输出文件;
        }
    }

    public function cancel()
    {
        echo "用户取消支付";
        return redirect('/home');
    }

    protected function purchase()
    {
        if (session()->has('content')) {
            $input = session('content');
            //支付完成购买
            $result = DB::transaction(function () use ($input) {
                //update mysql
                $art['user_id'] = Auth::user()->id;
                $art['title'] = $input['title'];
                $art['description'] = $input['description'];
                $art['path'] = $input['pic_url'][0];
                $art['average'] = $input['average'];
                $art['gender'] = $input['gender'];
                $art['race'] = $input['race'];
                $art['loyalty'] = $input['loyalty'];
                $art['created_at'] = Carbon::now();
                $art['updated_at'] = Carbon::now();
                $EventId = event::insertGetId($art);
                if ($EventId) {
                    $len = count($input['pic_ids']);
                    if ($len > 0) {
                        for ($i = 0; $i < $len; $i++) {
                            $allowed_extensions = array("png", "jpg", "gif", "bmp", "jpeg");
                            $file_d = substr($input['pic_name'][$i], strrpos($input['pic_name'][$i], '.') + 1);
                            if ($file_d && !in_array($file_d, $allowed_extensions)) {
                                return Redirect::back()->withInput()->with('msg', 'Only allowed to upload the file format: png, jpg, gif, bmp, jpeg');
                            } else if ($file_d == '') {
                                echo Redirect::back()->withInput()->with('msg', 'Only allowed to upload the file format: png, jpg, gif, bmp, jpeg');
                            } else {
                                $clientName = $input['pic_name'][$i];
                                $image['user_id'] = Auth::user()->id;
                                $image['event_id'] = $EventId;
                                $image['img_name'] = $input['pic_title'][$i];
                                $image['fingerprint'] = $fingerprint = uniqid() . '.' . $file_d;
                                $image['img_url'] = '/uploads/' . $clientName;
                                $image['created_at'] = Carbon::now();
                                $image['updated_at'] = Carbon::now();
                                $ImageId = image::insertGetId($image);
                                //upload to s3
                                $s3 = App::make('aws')->createClient('s3');
                                $result = $s3->putObject(array(
                                    'Bucket' => 'vmaxx1',
                                    'Key' => 'agel/' . $fingerprint,
                                    'SourceFile' => str_replace('\\', '/', public_path()) . '/uploads/' . $clientName,
                                ));
                            }
                        }
                        //message queue
                        $queueId = $this->dispatch(new SendReminderEmail(Auth::user()->id, $EventId));
                    }
                }
            });

            /*if (is_null($result)) {
                //清楚session里的数据
                session()->pull('content');
                $pictures = image::all()->pluck('img_url');
                $images = Storage::files('/');
                foreach ($images as $i) {
                    $image = '/uploads/' . $i;
                    if (!in_array($image, $pictures->toArray())) {
                        Storage::delete($i);
                    }
                }
                return redirect('/home');
            }*/
            return redirect('/home');
        } else {
            return redirect('/home');
        }
    }

    public function schedule(){
        $schedule = event::where('user_id', Auth::user()->id)->where('schedule','<',100)->orderBy('created_at', 'desc')->get();
        return Response::json($schedule);
    }

    public function email(Request $request)
    {
        $email = $request->input('email');
        $res = User::where('email',$email)->first();
        if($res){
            return '1';
        }else{
            return '0';
        }
    }
}