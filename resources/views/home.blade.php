@extends('layouts.app')
@section('content')
    <section class="home-text">
        <h1>Events</h1>
        <div class="home-text-right">
            <div class="recent-event">
                <div class="recent-event-upload">
                    <p>Latest Events</p>
                    <a href="{{ url('upload') }}">
                        <img src="{{ asset('image/newevent_button.png') }}" alt="">
                    </a>
                </div>
                <ul class="clickEvent">

                </ul>
            </div>
            <div class="all-event">
                <p>Previous Events</p>
                <ul class="clickEvent">

                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>
    <!-- <section class="promptProgress">
        <div class="Background-shadow"></div> -->
        <!-- <div class="promptText">
            <i class="material-icons character-Close">clear</i>
            <img class="loader" src="{{ asset('image/map.png') }}" alt="">
            <img class="promptSetting" src="{{ asset('image/setting.jpg') }}" alt="">
            <h2>Please wait while we're processing your data.</h2>
            <p>This may take a few minutes. Thank you for your patience.</p>
        </div> -->
    <!-- </section> -->
    @include('auth.setting')
@endsection
@section('pageEnd')
    @parent
    <script type="text/javascript" src="{{ asset('js/goalProgress.js') }}"></script>
    <script>
        $(function(){
            // 页面数据
            $.ajax({
                url: "list",
                type:"get",
                dataType:"json",
                headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                success:function(data){
                    $.each(data.round,function (key,val) {
                        var html = "<li id='" + val.id + "' class='recent"+val.id+"'>" +
                            '<img  src="'+val.path+'" alt="">'+
                            "<p>"+val.title+"</p>" +
                            "<span>"+val.created_at+"</span>" +
                            "<div class='aprogressBar'>" +
                            "<div class='progressBarStyle'> " +
                            "<div class='progressBackground'></div>" +
                            "<div class='container'><div class='sample" + val.id + "'></div></div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='recent-event-delete'>" +
                            "<img src='{{ asset('image/delete.png') }}' alt=''>" +
                            "<a> </a>"+
                            "</div>" +
                            "</li>";
                        $(".recent-event").find("ul").append(html);
                        $(".all-event").find("ul").append(html);

                        $(".sample"+val.id+"").goalProgress({
                            goalAmount: 100,
                            currentAmount: val.schedule,
                            textBefore: '',
                            textAfter: ' %'
                        });
                        //判断是否有数据
                        if(val.schedule == 100){
                            $(".recent"+val.id+"").find('.aprogressBar').css({display:"none"});
                        } else {
                            var set = setInterval(setData, 3000);
                            //回调数据
                            function setData() {
                                $.ajax({
                                    url: "list",
                                    type:"get",
                                    dataType:"json",
                                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                                    success:function(data){
                                        var widthf =$(".recent"+ val.id+"").find('.progressBar').width();
                                        var widths=$(".recent"+val.id+"").find('.container').width();
                                        if(widthf == widths){
                                            $(".recent"+val.id+"").find('.aprogressBar').css({display:"none"});
                                            clearInterval(set);
                                        }
                                        $(".sample"+val.id+"").html('');
                                        $.each(data.round,function (e,v) {
                                            $(".sample"+v.id+"").goalProgress({
                                                goalAmount: 100,
                                                currentAmount: v.schedule,
                                                textBefore: '',
                                                textAfter:' %'
                                            });
                                        });
                                    },
                                    error: function () {
                                        console.log("Failed to load")
                                    }
                                });
                                var widths=$(".recent"+val.id+"").find('.progressBar').width();
                                var swidths=$(".recent"+val.id+"").find('.container').width();
                                if(widths == swidths){
                                    $(".recent"+val.id+"").find('.aprogressBar').css({display:"none"});
                                    clearInterval(set);
                                }
                            }
                        }
                    });
                    RecentClick();
                },
                error:function(){
                    alert("Failed to load")
                }
            });
        });
        function RecentClick() {
            $(".home-text-right").find("li").hover(function () {
                $(this).find(".recent-event-delete").css({"display": "block"})
            }, function () {
                $(this).find(".recent-event-delete").css({"display": "none"})
            });
            $(".recent-event-delete").find("a").on("click",function () {
                var id=$(this).parents('li').attr("id");

                var hide = $(".recent"+id+"").find('.aprogressBar').css("display");
                var domain="http://"+window.location.host+"/detail/";
                if( hide !="none"){
                    var prompH = $(".promptText").height();
                    var prompW = $(".promptText").width();
                    var dH = ($(window).height() - prompH) / 2;
                    var dW = ($(window).width() - prompW) / 2;
                    $(".promptText").css({left:dW,top:dH});
                   $(".promptProgress").fadeIn();
                } else {
                    $(this).attr("href",domain+id);
                }
            });

            $(".recent-event-delete").find(".imgClick").on("click", function () {
                var id=$(this).parents('li').attr("id");
                var con = confirm("Are you sure you want to delete this activity?");
                if( con == true){
                    $.ajax({
                        url: '/move/'+id,
                        type: "get",
                        dataType: "json",
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        success: function () {
                            $(".all"+id+"").remove();
                            $(".recent"+id+"").remove();
                        },
                        error: function () {
                            alert("Delete failed")
                        }
                    });
                }
            });
        }
    </script>
@stop
