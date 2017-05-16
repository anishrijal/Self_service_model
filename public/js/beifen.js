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
        $("#login-style").css({display:"none"});
        $("#register-style").fadeOut();
    });

    $("#Prompt-login").find("span").on("click",function () {
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
            $(this).attr("href","http://54.218.58.200/home");
        }
    });

    $(".background").on("click",function () {
        $(".details-picture").css({dispaly:"none"});
    });

    /*****************************计算价钱***********************************/

    var ageOpen = 0, genderOpen = 0, EthnicityOpen = 0, LoyaltyOpen = 0;
    var agePrice = 1, genderPrice = 1, EthnicityPrice =1, LoyaltyPrice =1;
    var imgNumber = $(".photo-number").find("input").val();
    var TotalPrice = imgNumber * (agePrice + genderPrice + EthnicityPrice + LoyaltyPrice );
    $("#file").on("change", function () {
        var size = $(".news-center-left-text").find("li").size() - 1;
        imgNumber.val(size);
        var price = size * (agePrice + genderPrice + EthnicityPrice + LoyaltyPrice );
        $(".order-price").find("input").val(price);
    });
    $(".order-price").find("input").val(TotalPrice);


    /********************年龄价钱计算***********************/
    $("#Age").on("click", function () {
        if (ageOpen == 0) {
            $(this).find(".age-open-round").animate({right: 30}, 100).css({backgroundColor: "#939292"});
            var TotalPrices = $(".order-price").find("input").val();
            var imgNumbers = $(".photo-number").find("input").val();
            var prices = TotalPrices - agePrice * imgNumbers;
            $(".order-price").find("input").val(prices);
           // $(this).siblings("input").val(ageOpen);
            $("input[name=average]").val(ageOpen);
            return ageOpen = 1;
        } else {
            $(this).find(".age-open-round").animate({right: 0}, 100).css({backgroundColor: "#7385f6"});
            var ap = $(".order-price").find("input").val();
            var imgNumbers = $(".photo-number").find("input").val();
            var ag = agePrice * imgNumbers;
            console.log(agePrice, imgNumbers);
            var zz = Number(ap) + Number(ag);
            $(".order-price").find("input").val(zz);
            //$(this).siblings("input").val(ageOpen);
            $("input[name=average]").val(ageOpen);
            return ageOpen = 0;

        }
    });
    /***********************性别价钱计算****************************/
    $("#Gender").on("click", function () {
        if (genderOpen == 0) {
            $(this).find(".age-open-round").animate({right: 30}, 100).css({backgroundColor: "#939292"});
            var TotalPrices = $(".order-price").find("input").val();
            var imgNumbers = $(".photo-number").find("input").val();
            var prices = TotalPrices - genderPrice * imgNumbers;
            $(".order-price").find("input").val(prices);
            $("input[name=gender]").val(genderOpen);
            return genderOpen = 1;
        } else {
            $(this).find(".age-open-round").animate({right: 0}, 100).css({backgroundColor: "#7385f6"});
            var ap = $(".order-price").find("input").val();
            var imgNumbers = $(".photo-number").find("input").val();
            var ag = genderPrice * imgNumbers;
            var zz = Number(ap) + Number(ag);
            $(".order-price").find("input").val(zz);
            $("input[name=gender]").val(genderOpen);
            return genderOpen = 0;
        }
    });
    /******************种族价钱计算***********************/
    $("#Ethnicity").on("click", function () {
        if (EthnicityOpen == 0) {
            $(this).find(".age-open-round").animate({right: 30}, 100).css({backgroundColor: "#939292"});
            var TotalPrices = $(".order-price").find("input").val();
            var imgNumbers = $(".photo-number").find("input").val();
            var prices = TotalPrices - EthnicityPrice * imgNumbers;
            $(".order-price").find("input").val(prices);
            $("input[name=race]").val(EthnicityOpen);
            return EthnicityOpen = 1;
        } else {
            $(this).find(".age-open-round").animate({right: 0}, 100).css({backgroundColor: "#7385f6"});
            var ap = $(".order-price").find("input").val();
            var imgNumbers = $(".photo-number").find("input").val();
            var ag = EthnicityPrice * imgNumbers;
            var zz = Number(ap) + Number(ag);
            $(".order-price").find("input").val(zz);
            $("input[name=race]").val(EthnicityOpen);
            return EthnicityOpen = 0;
        }
    });
    /*******************忠诚度价钱计算****************************/
    $("#Loyalty").on("click", function () {
        if (LoyaltyOpen == 0) {
            $(this).find(".age-open-round").animate({right: 30}, 100).css({backgroundColor: "#939292"});
            var TotalPrices = $(".order-price").find("input").val();
            var imgNumbers = $(".photo-number").find("input").val();
            var prices = TotalPrices - LoyaltyPrice * imgNumbers;
            $(".order-price").find("input").val(prices);
            $("input[name=loyalty]").val(LoyaltyOpen);
            return LoyaltyOpen = 1;
        } else {
            $(this).find(".age-open-round").animate({right: 0}, 100).css({backgroundColor: "#7385f6"});
            var ap = $(".order-price").find("input").val();
            var imgNumbers = $(".photo-number").find("input").val();
            var ag = LoyaltyPrice * imgNumbers;
            var zz = Number(ap) + Number(ag);
            $(".order-price").find("input").val(zz);
            $("input[name=loyalty]").val(LoyaltyOpen);
            return LoyaltyOpen = 0;
        }
    });


    /***********************全选 全不选 以及删除*********************************/
    $(".Select").on("click", function () {
        if (this.checked) {
            $(".checkbox").css({"display": "block"});
            $("[name=checkboxt]:checkbox").prop("checked", true);
            $(".select-name").text("All don't choose");
        } else {
            $("[name=checkboxt]:checkbox").prop("checked", false);
            $(".select-name").text("Select");

        }
    });


    $(".delete").on("click", function () {
        $("[name=checkboxt]").each(function () {
            if ($(this).prop("checked") == true) {
                $(this).parent().remove();
            }
        });
        $(".Select").prop("checked", false);
        $(".select-name").text("Select");

        $(".Select").prop("checked",false);



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