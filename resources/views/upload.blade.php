@extends('layouts.app')

@section('content')
    <section class="news-text">
        <form action="{{ url('/payment/') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="news-center">
                <div class="news-center-left-head">
                    <span class="news-back">
                        <a href="javascript:history.go(-1);">
                            <i class="material-icons">arrow_back</i>Events
                        </a>
                    </span>
                    <div class="upload-title">New Project</div>
                </div>
                <div class="NewTitleLeft">
                    <div class="NewTitleContent" >
                        <input type="text" name="title" placeholder="Event Name">
                        <textarea name="description" id="description" placeholder="Event Description" ></textarea>
                    </div>
                    <div class="NewTitleContentRight">
                        <img src="{{ asset('image/uploadpic_button.png') }}" alt="">
                        <div id="file"></div>
                    </div>

                </div>
                <div class="NewTitleRight">
                    <div class="selectMetrices">
                        <p>Select metrices</p>
                        <div>
                            <input type="checkbox" name="average" checked="checked" value="1">
                            <span>Age</span>
                        </div>
                        <div>
                            <input type="checkbox" name="gender" checked="checked" value="1">
                            <span>Gender</span>
                        </div>
                        <div>
                            <input type="checkbox" name="race" checked="checked" value="1">
                            <span>Ethnicity</span>
                        </div>
                        <div style="display: none">
                            <input type="checkbox" name="loyalty" checked="checked"  value="1">
                            <span>Loyalty</span>
                        </div>
                    </div>
                    <div class="orderSummary">
                        <p>Order Summary</p>
                        <i class="material-icons Shopping">local_grocery_store</i>
                        <div>
                            Number of pictures:<input type="text" name="number" id="number" readonly="true" value="0">
                        </div>
                        <div>
                            Order total: <span>$ <input type="text" name="price" id="price" readonly="true" value="0"></span>
                        </div>
                        <button id="purchase" type="submit">Check Out</button>
                    </div>
                </div>
            </div>
            <div class="selectAll">
                <div class="selectAllHeader">
                    <div class="select-text">Select All</div>
                    <i class="material-icons delete">delete_forever</i>
                </div>
                <div class="clearfix"></div>
                <ul class="PictureShow"></ul>
            </div>
        </form>
    </section>
@endsection
@section('pageEnd')
    @parent
    <script type="text/javascript" src="{{ asset('js/uploadify/jquery.uploadify.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            /**
             *  判断是否存在图片
             */
            $(".hx").each(function () {
                if ($(this).find('img').length) {
                    $(this).css('display', 'block');
                }
            });
            $("#file").uploadify({
                'formData': {
                    'timestamp': '<?php echo time();?>',
                    'token': '<?php echo md5('unique_salt' . time())?>'
                },
                'uploader': '/js/uploadify/uploadify.php',
                'swf': '/js/uploadify/uploadify.swf',
                'width': '100%',
                'height': '100%',

                'fileSizeLimit': '99999KB',
                'fileTypeExts': '*.*',
                'buttonClass': 'uploadify-button',
                'buttonText': 'SELECT FILES',
                'checkExisting': '/js/uploadify/check-exists.php',
                'debug': false,
                'multi': true,
                'onUploadStart': function (file) {
                    var hx = $(".PictureShow").find(".pic_1").length;
                    if (parseInt(hx) >= 5000) {
                        alert('You can only upload up to 100 photos');
                        $('#file').uploadify('cancel', file.id);
                    }
                    var imgSrc= '{{ asset('image/loading.gif') }}';
                    var imgList = '';
                    imgList += '<li class="pic_1 FalseData">' +
                        '<div class="timeOut"><img src="'+imgSrc+'" alt=""></div>'+
                        '</li>';
                    $('.PictureShow').append(imgList);
                },
                'onUploadError': function (file, errorCode, errorMsg, errorString) {
                    if (errorString != 'Cancelled') {
                        alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                    }
                },
                'onUploadSuccess': function (file, data, response) {
                    $(".FalseData").remove();
                    $('#' + file.id).find('.data').html(' Upload completed');
                    var src = '/uploads/' + data;
                    var imgList = '';
                    imgList += '<li class="pic_1">' +
                        '<input type="checkbox" class="checkbox" name="checkboxt">' +
                        '<img class="img-Graphical" src="' + src + '" alt="">' +
                        '<input type="text" value="" placeholder="img_1" name="pic_title[]">' +
                        '<i class="material-icons">create</i>'+
                        '<div class="news-img-delete">' +
                        '<div></div>'+
                        '<i class="material-icons">delete_forever</i>'+
                        '</div>' +
                        '<input type="hidden" name="pic_name[]" value="' + data + '" />' +
                        '<input type="hidden" name="pic_ids[]" value="0" />' +
                        '<input type="hidden" name="pic_url[]" value="/uploads/' + data + '" />' +
                        '</li>';
                    $('.PictureShow').append(imgList);

                    var size = $(".PictureShow").find("li").size();
                    $("#number").val(size);
                    if(size<=1000){
                        $("#price").val(500)
                    } else  if( 2000>=size && size>1000){
                        $("#price").val(900)
                    } else if( 5000>=size && size>2000){
                        $("#price").val(1800)
                    } else if(size>5000){
                        alert("please contact Vmaxx");
                        $("#price").val(0)
                    }
                    $(".order-price").find("input").val(price);
                    $(".checkbox").on("click", function () {
                        var size=$(".checkbox").size();
                        var indexs = [];
                        $(".checkbox").each(function () {
                            if ($(this).prop("checked") == true) {indexs.push($(this).parent().index());}
                        });
                        var lengths=indexs.length;
                        if(lengths==size){
                            $(".select-text").text("All Unchecked");
                        } else {
                            $(".select-text").text("Select All");
                        }
                    });
                    $(".news-img-delete").find("i").on("click", function () {
                        var size=$(".PictureShow").find("li").size();
                        $(this).parent().parent().remove();
                        $("#number").val(size);
                    });
                    $(".PictureShow").find("li").hover(function () {
                        $(this).find(".news-img-delete").css({"display": "block"})
                    }, function () {
                        $(this).find(".news-img-delete").css({"display": "none"})
                    });
                }
            });
            $("input[name=average]").on("click",function () {
                if($(this).prop("checked") == true){$(this).val(1)} else {$(this).val(0)}
            });
            $("input[name=gender]").on("click",function () {
                if($(this).prop("checked") == true){$(this).val(1)} else {$(this).val(0)}
            });
            $("input[name=race]").on("click",function () {
                if($(this).prop("checked") == true){$(this).val(1)} else {$(this).val(0)}
            });
            $("input[name=loyalty]").on("click",function () {
                if($(this).prop("checked") == true){$(this).val(1)} else {$(this).val(0)}
            });


            $("#purchase").on("click",function () {
                var liZize=$(".PictureShow").find("li").size();
                if(liZize == 0){
                    alert("Please upload pictures");
                    return false
                }
            })
        });
    </script>
@stop
