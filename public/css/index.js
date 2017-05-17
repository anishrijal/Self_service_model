$(function () {

    $("#header-login").on("click",function () {
        $("#LoginText").fadeIn();
        $("#login-style").css({display:"block"});
        $("#register-style").css({display:"none"});
    });
    $("#login-return").on("click",function () {
        $("#LoginText").fadeOut();
        $("#login-style").fadeOut();
        $("#register-style").css({display:"none"});
    });
    $("#header-register").on("click",function () {
        $("#LoginText").fadeIn();
        $("#login-style").css({display:"none"});
        $("#register-style").css({display:"block"});
    });
    $("#register-return").on("click",function () {
        $("#LoginText").fadeOut();
        $("#register-style").fadeOut();
        $("#login-style").fadeOut();
        $("#setting").fadeOut();
    });
    $(".headerRegister").on("click",function () {
        $("#setting").fadeIn();
        $("#setting-style").fadeIn();
    });
    $(".settingDate").on("click",function () {
        $("#setting").fadeIn();
        $("#setting-style").fadeIn();
    });
    $(".registerLogin").find("span").on("click",function () {
        $("#login-style").fadeIn();
        $("#register-style").fadeOut();
    });
    $(".index-header").find("a").on("click",function () {
        var name=$(".header-right").find("p");
        if(name.html()==''){
            $("#LoginText").fadeIn();
            $("#login-style").css({display:"none"});
            $("#register-style").fadeIn();
        }else {
            $(this).attr("href","http://54.203.24.181/home");
        }
    });
    $(".background").on("click",function () {
        $(".details-picture").css({dispaly:"none"});
    });


    $("#Prompt-login").find("span").on("click",function () {
        $("#register-style").fadeOut();
        $("#Agreement-style").fadeIn();
    });
    $(".YesAgreement").find("p").on("click",function () {
        $("#register-style").fadeIn();
        $("#Agreement-style").fadeOut();
        $("#Prompt-login").find("input").prop("checked",false);
    });
    $(".YesAgreement").find("span").on("click",function () {
        $("#register-style").fadeIn();
        $("#Agreement-style").fadeOut();
        $("#Prompt-login").find("input").prop("checked",true);
    });

    $(".clickHide").on("click",function () {
       var text=$(this).find("i").text();
       if(text=="keyboard_arrow_up"){
           $(".details-center-right").animate({
               height:63
           },1000);
           $(this).find("i").text("keyboard_arrow_down");
           // $(".details-center-left-text").animate({
           //     top:140
           // },1000)
       } else {
           $(".dataExhibition").height();
           $(".details-center-right").animate({
               height:$(".dataExhibition").height()+55
           },1000);
           setTimeout(function(){
               $(".details-center-right").css('height','auto')
           },1001)
           $(this).find("i").text("keyboard_arrow_up");
           // $(".details-center-left-text").animate({
           //     top:380
           // },1000)
       }
   });








    /***********************全选 全不选 以及删除*********************************/
    $(".select-text").on("click", function () {
        var size=$(".PictureShow").find("li").size();
        if(size == 0){
            alert("No one can be selected")
        }else {
            if ($(this).html()=="Select All") {
                $(".checkbox").css({"display": "block"});
                $("[name=checkboxt]:checkbox").prop("checked", true);
                $(this).html("All Unchecked")
            } else {
                $("[name=checkboxt]:checkbox").prop("checked", false);
                $(this).html("Select All")
            }
        }

    });
    $(".delete").on("click", function () {
        $("[name=checkboxt]").each(function () {
            if ($(this).prop("checked") == true) {
                $(this).parent().remove();
            }
        });
        var size=$(".PictureShow").find("li").size();
        $("#number").val(size);
        $(".select-text").html("Select All");
        if(size == 0 ){
            $("#price").val(0)
        }

    });
    $(".news-img-delete").on("click", function () {
        var imgH = $(".view-img").height();
        var dH = ($(window).height() - imgH) / 2;
        var dW = ($(window).width() - 750) / 2;
        $('.view-img').css({left: dW, top: dH});
        $(".view-picture").css({display: "block"});
        var imgsrc = $(this).parent().find(".img-Graphical").attr("src");
        var imgname = $(this).parent().find("input[type=text]").val();
        $(".view-img").find("img").attr("src", imgsrc);
        $(".view-img").find("p").html(imgname);
        $(".view-Close").on("click", function () {
            $(".view-picture").css({display: "none"})
        })
    });

    $(".data-title").find("i").on("click",function () {
      $(".activityInformation").css({display: 'flex', opacity:0});
        $(".activityInformation").animate({
          opacity:1,
        }, 500);
        // $(".activityInformation").fadeIn();
        // var aH = ($(window).height() - $(".activityText").height()) / 2;
        // var aW = ($(window).width() - $(".activityText").width()) / 2;
        // $(".activityText").css({left:aW, top:aH});
    });

    $(".activityText").find("i").on("click",function () {
        $(".activityInformation").fadeOut();
    });


    $('#description').bind({
        focus: function () {
            if (this.value == this.defaultValue) {
                this.value = "";
            }
        },
        blur: function () {
            if (this.value == "") {
                this.value = this.defaultValue;
            }
        }
    });



});
