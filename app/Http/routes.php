<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//跨域访问
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3628800");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: content-type");

Route::group(['middleware' => ['web']], function () {
    //前台
    //用户个人主页
    //创建支付
    Route::post('/payment','HomeController@payment');
    //执行支付，用户授权返回地址
    Route::get('/exec','HomeController@exec');
    //用户取消支付
    Route::get('/cancel','HomeController@cancel');

    Route::auth();
    Route::get('/home', 'HomeController@index');
    Route::get('/setting', 'HomeController@setting');
    Route::get('/settings/', 'HomeController@settings');
    Route::get('/upload', 'HomeController@upload');
    Route::post('/upload', 'HomeController@upload');
    Route::get('/detail/{id}', 'HomeController@detail');
    Route::get('/details/{id}', 'HomeController@details');
    Route::get('/purchase', 'HomeController@purchase');
    Route::post('/purchase', 'HomeController@purchase');
    Route::get('/list', 'HomeController@lists');
    Route::get('/move/{id}', 'HomeController@move');
    Route::get('/move_all', 'HomeController@move_all');
    Route::get('/export','HomeController@export');
    Route::post('/user/email','HomeController@email');
  /*  Route::post('/user/password','HomeController@password');*/
    Route::post('/checks', 'HomeController@check');
    Route::get('/', function () {
        return view('welcome');
    });

    //后台
    Route::get('admin/login', 'Admin\AuthController@getLogin');
    Route::post('admin/login', 'Admin\AuthController@postLogin');
    Route::get('admin/register', 'Admin\AuthController@getRegister');
    Route::post('admin/register', 'Admin\AuthController@postRegister');
    Route::get('admin', 'AdminController@index');
});




