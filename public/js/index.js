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
        var domain="http://"+window.location.host+"/home";
       if(name.html()==''){
           $("#LoginText").fadeIn();
           $("#login-style").css({display:"none"});
           $("#register-style").fadeIn();
       }else {
           $(this).attr("href",domain);
       }
    });
    $(".background").on("click",function () {
        $(".details-picture").css({dispaly:"none"});
    });
    $("#Agreement-style").find("i").on("click",function () {
        $("#Agreement-style").fadeOut();
        $("#register-style").fadeIn();
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

    $(".promptText").find("i").on("click",function () {
       $(".promptProgress").fadeOut();
    });

    $("#forget-return").on("click",function () {
            $("#LoginText").fadeOut();
            $("#forgetPassword").fadeOut();
    });
    $(".login-foot").find("a").on("click",function () {
        $("#login-style").fadeOut();
        $("#forgetPassword").fadeIn();
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


    // 重新设置个人信息
        // var dW = ($(window).width() - $("#setting-style").width()) / 2;
        // var dH = ($(window).height() - $("#setting-style").height()) / 2;
        // $("#setting-style").css({left: dW, top: dH});
        //更新资料
        $("#setting-return").on("click",function () {
            $("#LoginText").fadeOut();
            $("#register-style").fadeOut();
            $("#login-style").fadeOut();
            $("#setting").fadeOut();
        });
        var user=$.trim($("#settingName").val());
        $("#settingName").val(user);
        var lastname=$.trim($("#settingLastName").val());
        $("#settingLastName").val(lastname);
        var company =$.trim($("#settingCompany").val());
        $("#settingCompany").val(company);
        var phones=$.trim($("#settingPhone").val());
        $("#settingPhone").val(phones);
        var setPassword = $("#settingPassword").val();
        var subPassword = setPassword.substring(0,6);
        $("#settingPassword").val(subPassword);
        var setPasswordConfirm = $("#settingPasswordConfirm").val();
        var subPasswordConfirm = setPasswordConfirm.substring(0,6);
        $("#settingPasswordConfirm").val(subPasswordConfirm);

        $("#settingLastName").blur(function(){
            var text=$(this).parent().find("p");
            if($(this).val() == ""){
                text.css({display:"block"}).html(" Last Name cannot be empty");
                return false;
            }else {
                text.css({display:"none"})
            }
        });
        $("#settingName").blur(function(){
            var text=$(this).parent().find("p");
            if($(this).val() == ""){
                text.css({display:"block"}).html("Name cannot be empty");
                return false;
            }else {
                text.css({display:"none"})
            }
        });
        $("#settingCompany").blur(function(){
            var text=$(this).parent().find("p");
            if($(this).val() == ""){
                text.css({display:"block"}).html("Company Name cannot be empty");
                return false;
            }else {
                text.css({display:"none"})
            }
        });
        $("#settingPhone").blur(function(){
            var text=$("#settingPhone").parent().find("p");
            var phone=/\d{3,18}$/;
            if (!phone.test($(this).val())) {
                text.css({display: "block"}).html("Please enter the correct phone number");
                return false;
            } else {
                text.css({display: "none"})
            }
        });
        $("#settingEmail").blur(function(){
            var text = $(this).parent().find("p");
            var email = /^\w{3,}@\w+(\.\w+)+$/;
            if (!email.test($(this).val())) {
                text.css({display: "block"}).html("Please enter the correct mailbox :xxx@qq.com");
                return false;
            } else {
                text.css({display: "none"})
            }
        });
        $("#settingPassword").blur(function(){
            var text=$(this).parent().find("p");
            if($(this).val() == ""){
                text.css({display:"block"}).html("Password  cannot be empty");
                return false;
            }else {
                text.css({display:"none"})
            }
        });
        $("#settingPasswordConfirm").blur(function(){
            var password=$("#settingPassword").val();
            var text=$(this).parent().find("p");
            if($(this).val()!=password){
                text.css({display:"block"}).html("Two passwords are not the same");
                return false;
            }else {
                text.css({display:"none"})
            }
        });
        //点击更新资料提交
        $("#settingSubmit").on("click",function(){
            if($("#settingName").val()==""){
                var text=$("#settingName").parent().find("p");
                text.css({display:"block"}).html("First Name cannot be empty");
                return false;
            }
            if($("#settingLastName").val()==""){
                var text=$("#settingLastName").parent().find("p");
                text.css({display:"block"}).html("Last Name cannot be empty");
                return false;
            }
            if($("#settingCompany").val()==""){
                var text=$("#settingCompany").parent().find("p");
                text.css({display:"block"}).html("Company Name cannot be empty");
                return false;
            }

            var phoneText=$("#settingPhone").parent().find("p");
            var phone=/\d{3,18}$/;
            if (!phone.test($("#settingPhone").val())) {
                phoneText.css({display: "block"}).html("Please enter the correct phone number");
                return false;
            } else {
                phoneText.css({display: "none"})
            }


            var emailText = $("#settingEmail").parent().find("p");
            var email = /^\w{3,}@\w+(\.\w+)+$/;
            if (!email.test($("#settingEmail").val())) {
                emailText.css({display: "block"}).html("Please enter the correct mailbox :xxx@qq.com");
                return false;
            } else {
                emailText.css({display: "none"})
            }

            if($("#settingPassword").val()==""){
                var text=$("#settingPassword").parent().find("p");
                text.css({display:"block"}).html("Password cannot be empty");
                return false;
            }
            var password=$("#settingPassword").val();
            if($("#settingPasswordConfirm").val()!=password){
                var text=$("#settingPasswordConfirm").parent().find("p");
                text.css({display:"block"}).html("Two passwords are not the same");
                return false;
            }
            $.ajax({
                url: "/settings",
                type:"get",
                dataType:"json",
                data:$('form').serialize(),
                headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                success:function(){
                    alert("Modify success");
                    $("#register-style").fadeOut();
                    $("#setting").fadeOut();
                },
                error:function(){
                    alert("Failed to load")
                }
            });
        });



    //登录注册忘记密码自动居中
    // var lW = ($(window).width() - $("#login-style").width()) / 2;
    // var lH = ($(window).height() - $("#login-style").height()) / 2;
    // $("#login-style").css({left: lW, top: lH});
    // var rW = ($(window).width() - $("#register-style").width()) / 2;
    // var rH = ($(window).height() - $("#register-style").height()) / 2;
    // $("#register-style").css({left: rW, top: rH});
    var AW=  ($(window).width()  - 580) / 2;
    $("#Agreement-style").css({left: AW});
    var fW = ($(window).width() - $("#forgetPassword").width()) / 2;
    var fH = ($(window).height() - $("#forgetPassword").height()) / 2;
    $("#forgetPassword").css({left: fW, top: fH});


    //注册正则验证
    $("#registerName").blur(function () {
        var text = $(this).parent().find("p");
        if ($(this).val() == "") {
            text.css({display: "block"}).html("Name  cannot be empty");
            return false;
        } else {
            text.css({display: "none"})
        }
    });
    $("#registerLastName").blur(function () {
        var text = $(this).parent().find("p");
        if ($(this).val() == "") {
            text.css({display: "block"}).html("Last name  cannot be empty");
            return false;
        } else {
            text.css({display: "none"})
        }
    });
    $("#registerPhone").blur(function () {
        var text = $(this).parent().find("p");
        var phone=/\d{3,18}$/;
        if (!phone.test($(this).val())) {
            text.css({display: "block"}).html("Please enter the correct phone number");
            return false;
        } else {
            text.css({display: "none"})
        }
    });
    $("#registerCompany").blur(function () {
        var text = $(this).parent().find("p");
        if ($(this).val() == "") {
            text.css({display: "block"}).html("Company Name  cannot be empty");
            return false;
        } else {
            text.css({display: "none"})
        }
    });
    $("#registerEmail").blur(function () {
        var email_val = $(this).val();
        var text = $(this).parent().find("p");
        var email = /^\w{3,}@\w+(\.\w+)+$/;
        if (!email.test($(this).val())) {
            text.css({display: "block"}).html("Please enter the correct mailbox :xxx@qq.com");
            return false;
        } else {
            var token = $('#token').val();
            $.post('/user/email',{'_token':token,'email':email_val},function(data){
              if(data == 1){
                  text.css({display: "block"}).html("This E-mail has been registered");
                  return false;
              } else {
                  text.css({display: "none"})
              }
            });

        }
    });
    $("#registerPassword").blur(function () {
        var text = $(this).parent().find("p");
        var password = /^(\w){6,20}$/;
        if (!password.test($(this).val())) {
            text.css({display: "block"}).html("Enter only 6-20 letters, numbers, underscores");
            return false;
        } else {
            text.css({display: "none"})
        }
    });
    $("#registerPasswordConfirm").blur(function () {
        var text = $(this).parent().find("p");
        var m = $("#registerPassword").val();
        if ($(this).val() != m) {
            text.css({display: "block"}).html("Two passwords are not the same");
            return false;
        } else {
            text.css({display: "none"})
        }
    });

    // 点击注册提交
    $("#registerSubmit").on("click", function () {
        if ($("#registerName").val() == "") {
            var text = $("#registerName").parent().find("p");
            text.css({display: "block"}).html("Name cannot be empty");
            return false;
        }
        if ($("#registerLastName").val() == "") {
            var text = $("#registerLastName").parent().find("p");
            text.css({display: "block"}).html("Last Name cannot be empty");
            return false;
        }
        if ($("#registerCompany").val() == "") {
            var text = $("#registerCompany").parent().find("p");
            text.css({display: "block"}).html("Company Name cannot be empty");
            return false;
        }
        var phone=/\d{3,18}$/;
        var phoneP = $("#registerPhone").parent().find("p");
        if (!phone.test($("#registerPhone").val())){
            phoneP.css({display: "block"}).html("Please enter the correct phone number");
            return false;
        } else {
            phoneP.css({display: "none"})
        }

        var namepassword = /^(\w){6,20}$/;
        var namepasswordP = $("#registerPassword").parent().find("p");
        if (!namepassword.test($("#registerPassword").val())) {
            namepasswordP.css({display: "block"}).html("Enter only 6-20 letters, numbers, underscores");
            return false;
        } else {
            namepasswordP.css({display: "none"})
        }

        var password = $("#registerPassword").val();
        var PasswordConfirmP = $("#registerPasswordConfirm").parent().find("p");
        if ($("#registerPasswordConfirm").val() != password) {
            PasswordConfirmP.css({display: "block"}).html("Two passwords are not the same");
            return false;
        } else {
            PasswordConfirmP.css({display: "none"})
        }

        var EmailP = $("#registerEmail").parent().find("p");
        var email = /^\w{3,}@\w+(\.\w+)+$/;
        if (!email.test($("#registerEmail").val())) {
            EmailP.css({display: "block"}).html("Please enter the correct mailbox :xxx@qq.com");
            return false;
        }
        if($("input[name=checkboxs]").prop('checked')!=true){
            alert("Please read the agreement and agree to the above requirements");
            return false;
        }
        var EmailHide=EmailP.css("display");
        if(EmailHide =="block"){
            return false;
        }
        $("#register").submit();
    });

    //忘记密码提交
    $("#forgetEmail").blur(function () {
        var text = $(this).parent().find("p");
        var email = /^\w{3,}@\w+(\.\w+)+$/;
        if (!email.test($(this).val())) {
            text.css({display: "block"}).html("Please enter the correct mailbox :xxx@qq.com");
            return false;
        } else {
            text.css({display: "none"})
        }
    });
    $("#modifyPassword").on("click",function () {
        var text = $("#forgetEmail").parent().find("p");
        var email = /^\w{3,}@\w+(\.\w+)+$/;
        if(!email.test($("#forgetEmail").val())){
            text.css({display: "block"}).html("Please enter the correct Email");
            return false;
        } else {
            text.css({display: "none"});
            alert("Please change the password in your mailbox");
            $("#forgetSubmit").submit();
        }
    });


   /* //点击登录


    $("#login").on("click",function () {
        var tokens = $('#token').val();
        var name=$("#loginEmail").val();
        var nameP=$("#loginP");
       var namePassword=$("#password").val();
        $.post('/user/email',{'_token':tokens,'email':name},function(data){
            if(data == 0){
                nameP.css({display: "block"}).html("This user does not exist");
                return false;
            } else {
                $.post('/user/password',{'_token':tokens,'password':namePassword},function(data){
                    console.log(data);
                })
            }
        });

    })*/


});
