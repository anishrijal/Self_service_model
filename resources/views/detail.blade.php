@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/image-crop-styles.css') }}">
    <form action="{{ url('/export') }}" method="get" enctype="multipart/form-data">
        <section class="news-text">
            <div class="news-center-left">
                <div class="news-center-left-head">
                    <span class="news-back data-back">
                        <a href="javascript:history.go(-1);">
                            <i class="material-icons">arrow_back</i>Events
                        </a>
                    </span>
                    <div class="data-title"><span>  </span> <i class="material-icons">info_outline</i></div>
                </div>
            </div>
            <div class="details-center-right">
                <div class="detailsTitle">
                    <h1>Results</h1>
                    <span class="clickHide">
                        <i class="material-icons">keyboard_arrow_up</i>
                    </span>
                    <input type="submit" id="buttons" value="Download">
                    <select name="checkbox" id="downloadType">
                        <option value="pz">Please select download type</option>
                        <option value="ZIP">XML</option>
                        <option value="PDF">PDF</option>
                        <option value="pz">XML and PDF</option>
                    </select>
                    <input type="hidden" id="img_id" name="event_id" value="{{$id}}">
                </div>
                <div class="allDataStatistics">
                    <div>
                        <p>Total Number of Photos</p>
                        <span id="allImageNumber">0</span>
                    </div>
                    <div>
                        <p>Total Faces Detected</p>
                        <span id="allCharacterNumber">0</span>
                    </div>
                    <div>
                        <p>Unique Faces</p>
                        <span id="NoRepeatCharacters">0</span>
                    </div>
                    <div>
                        <p>Repeating faces</p>
                        <span id="RepeatCharacters">0</span>
                    </div>
                </div>
                <div class="dataExhibition">
                    <div class="details-age">
                        <p>Age</p>
                        <div id="detailsAge"></div>
                    </div>

                    <div class="gender">
                        <p>Gender</p>
                        <div id="gender"></div>
                    </div>
                    <div class="race">
                        <p>Race</p>
                        <div id="race"></div>
                    </div>
                </div>
            </div>
            <div class="details-center-left-text">
                <div class="detailsEvents">
                    <p>Pictures</p>
                    <span class="selected" >View Selected</span>
                </div>
                <ul></ul>
            </div>
        </section>
    </form>
    <section class="character-data">
        <div class="background"></div>
        <div class="character-text">
            <i class="material-icons character-Close">clear</i>
            <h3>Demographics per picture</h3>
            <div class="character-text-left">
                <h6>Group</h6>
                <p id="GroupNumber"></p>
                <div class="Circular-data">
                    <div class="Circular-data-text">
                        <div id="circularAge"></div>
                        <i>Age</i>
                    </div>
                    <div class="Circular-data-text">
                        <div id="circularGender"></div>
                        <i>Gender</i>
                    </div>
                    <div class="Circular-data-text">
                        <div id="circularEthnicity"></div>
                        <i>Race</i>
                    </div>
                </div>
                <div id="personalData"><img src="" alt=""></div>
            </div>
            <div class="character-text-right">
                <h6>Individual</h6>
                <p>Select a face from the picture to view individual's metrices</p>
                {{--   <img src="" alt="">--}}
                <canvas id="myCanvas">

                </canvas>
                <div id="RunData"></div>
            </div>
        </div>
    </section>
    <section class="details-picture">
        <div class="background"></div>
        <div class="details-text">
            <i class="material-icons details-Close">clear</i>
            <div class="details-text-title">
                <p>Pictures:&numsp;<span id="detailsImgNumber">0</span> </p>
                <p style="margin-left: 50px">People detected:&numsp;<span id="detailsCharacterNumber">0</span> </p>
            </div>
            <div id="selectedAge"></div>
            <div id="selectedGender"></div>
            <div id="selectedRace"></div>
            <div class="clearfix"></div>

        </div>
    </section>
    <section class="activityInformation">
        <div class="background"></div>
        <div class="activityText">
            <i class="material-icons">clear</i>
            <h1></h1>
            <p></p>
            <div></div>
        </div>
    </section>
@endsection
@section('pageEnd')
    @parent
    <script type="text/javascript" src="{{ asset('js/highcharts-more.js') }}"></script>
    <script type="text/javascript">
        $(function () {


            var resultsH =$(".details-center-right").height()+20;
            var detailsEventsT =$(".details-center-left-text").offset().top - 100;
            $(".clickHide").on("click",function () {

                var text=$(this).find("i").text();
                var WalkHow =resultsH-60;
                var muchHow =detailsEventsT - WalkHow;

                if(text=="keyboard_arrow_up"){
                    $(".details-center-right").animate({
                        height:60
                    },1000);
                    $(this).find("i").text("keyboard_arrow_down");
                    $(".details-center-left-text").animate({
                        top:muchHow
                    },1000)
                } else {
                    $(".details-center-right").animate({
                        height:resultsH
                    },1000);
                    $(this).find("i").text("keyboard_arrow_up");
                    $(".details-center-left-text").animate({
                        top:detailsEventsT
                    },1000)
                }
            });


            var  id = $('#img_id').val();
            $.ajax({
                url: '/details/' + id,
                type: "get",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                success: function (data) {
                    var females = 0, men = 0, low = 0, middle = 0, high = 0, Asian = 0, Hispanic = 0, Africa = 0, Caucasian = 0
                        , agetwenty = 0, ByTwentyFive = 0, ByThirty = 0, ByThirtyFive = 0, ByForty = 0, ByFortyFive = 0
                        , ByFifty = 0, ByFiftyFive = 0, BySixty = 0, thanSixty = 0;
                    $.each(data.list, function (key, val) {
                        var html = "<li>" +
                            "<input type='checkbox' class='checkbox' name='checkboxt'>" +
                            "<img class='img-Graphical' src='" + val.img_url + "' alt=''>" +
                            "<p>" + val.img_name + "</p>"+
                            "<i class='material-icons'>create</i>"+
                            "</li>";
                        $(".details-center-left-text").find("ul").append(html);
                        $(".activityText").find("h1").html(val.author.title);
                        $(".activityText").find("p").html(val.author.created_at);
                        $(".activityText").find("div").html(val.author.description);
                        $(".data-title").find("span").html(val.author.title)
                    });

                    $(".checkbox").on("click", function () {
                        var indexs = [];
                        $(".checkbox").each(function () {
                            if ($(this).prop("checked") == true) {indexs.push($(this).parent().index());}
                        });
                        var lengths=indexs.length;
                        if(lengths== 0 ){
                            $(".selected").css({backgroundColor:"#afb1b3"})
                        } else {
                            $(".selected").css({backgroundColor:"#2f9dd8"})
                        }
                        $("#detailsImgNumber").html(lengths);
                    });


                    // 点击图片获取相应的数据
                    $(".details-center-left-text").find("ul").find("li").find("img").on("click", function () {

                        /*============获取图片和名称==================*/
                        var imgsrc = $(this).attr("src");
                        var ptext = $(this).next().html();
                        $(".character-text-left").find("p").html(ptext);
                        $(".character-text-left").find("img").attr("src", imgsrc);

                        var canvas = document.getElementById("myCanvas");
                        var ctx = canvas.getContext("2d");
                        ctx.clearRect(0,0,canvas.width,canvas.height);

                        /* =============显示和关闭===============*/
                        $(".character-data").css({display: "block"});
                        $(".character-Close").on("click", function () {
                            $(".character-data").css({display: "none"})
                        });

                        /*=============自动居中=====================*/
                        var imgH = $(".character-text").height();
                        var imgW= $(".character-text").width();
                        var dH = ($(window).height() - imgH) / 2;
                        var dW = ($(window).width() - imgW) / 2;
                        $('.character-text').css({left: dW, top: dH});
                        var index = $(this).parent().index();
                        $(".character-text-left").find("div").find("span").remove();

                        /*==============对应的数据===============*/
                        var gfemales = 0, gmen = 0, glow = 0, gmiddle = 0, ghigh = 0, gAsian = 0, gHispanic = 0, gAfrica = 0, gCaucasian = 0
                            , gagetwenty = 0, gByTwentyFive = 0, gByThirty = 0, gByThirtyFive = 0, gByForty = 0, gByFortyFive = 0
                            , gByFifty = 0, gByFiftyFive = 0, gBySixty = 0, gthanSixty = 0;

                        $.each(data.list_a[index], function (d, s) {
                            var imgLeft=[];
                            var imgTop=[];
                            var imgWidth=[];
                            var imgHeight=[];
                            $.each(s, function (f, z) {
                                if( z.position!=''){
                                    var positions = z.position.split(" ");
                                    var lefts = (positions[0]) * 100;
                                    var tops = (positions[1]) * 100;
                                    var kuis = (positions[2]) * 100;
                                    var gaos = (positions[3]) * 100;
                                    var div = "<span style='width:" + kuis + "%;height:" + gaos + "%;top:" + tops + "%;left:" + lefts + "%;position: absolute'></span>";
                                    $(".character-text-left").find("#personalData").append(div);

                                    imgLeft.push(lefts);
                                    imgTop.push(tops);
                                    imgWidth.push(kuis);
                                    imgHeight.push(gaos);

                                } else {
                                    return true;
                                }
                                /***************判断所对应的数据**************************/
                                if (z.gender == "female") {gfemales = gfemales + 1;}
                                if (z.gender == "male") {gmen = gmen + 1;}
                                if (z.loyalty == "low") {glow = glow + 1;}
                                if (z.loyalty == "middle") {gmiddle = gmiddle + 1;}
                                if (z.loyalty == "high") {ghigh = ghigh + 1;}
                                if (z.race == "Caucasian") {gCaucasian = gCaucasian + 1;}
                                if (z.race == "African") {gAfrica = gAfrica + 1;}
                                if (z.race == "Asian") {gAsian = gAsian + 1;}
                                if (z.race == "Hispanic") {gHispanic = gHispanic + 1;}
                                if (z.age == "20-25") {gByTwentyFive = gByTwentyFive + 1}
                                if (z.age == "25-30") {gByThirty = gByThirty + 1}
                                if (z.age == "30-35") {gByThirtyFive = gByThirtyFive + 1}
                                if (z.age == "35-40") {gByForty = gByForty + 1}
                                if (z.age == "40-45") {gByFortyFive = gByFortyFive + 1}
                                if (z.age == "45-50") {gByFifty = gByFifty + 1}
                                if (z.age == "50-55") {gByFiftyFive = gByFiftyFive + 1}
                                if (z.age == "55-60") {gBySixty = gBySixty + 1}
                                if (z.age == "0-20") {gagetwenty = gagetwenty + 1}
                                if (z.age == ">60") {gthanSixty = gthanSixty + 1}
                            });
                            var ageconf = Number(s[0].age_conf).toFixed(2);
                            var genderconf = Number(s[0].gender_conf).toFixed(2);
                            var receconf = Number(s[0].race_conf).toFixed(2);
                            var loyaltyconf = Number(s[0].loyalty_conf).toFixed(2);
                            var ageValue = 0, genderValue = 0, raceValue = 0, loyaltyValue = 0;
                            var gendercolors = "#de443c";
                            if (s[0].gender == "male") {
                                gendercolors = "#2e9dd9";
                            } else {
                                gendercolors = "#de443c";
                            }
                            $.each(data.list, function (j, m) {
                                /***********判断是否有年龄******************/
                                if (m.author.average == 0) {
                                    ageValue = 0;
                                } else {
                                    ageValue = ageconf;
                                }
                                /***********判断是否有性别******************/
                                if (m.author.gender == 0) {
                                    genderValue = 0
                                } else {
                                    genderValue = genderconf
                                }

                                /***********判断是否有种族******************/
                                if (m.author.race == 0) {
                                    loyaltyValue = 0
                                } else {
                                    loyaltyValue = loyaltyconf
                                }
                            });
                            var chart = Highcharts.chart('RunData', {
                                title: {text: ''},
                                subtitle: {text: ''},
                                xAxis: {categories: [s[0].age, s[0].gender, s[0].race, s[0].loyalty]},
                                bar: {dataLabels: {enabled: true}},
                                series: [{
                                    name: 'Number',
                                    type: 'column',
                                    colorByPoint: true,
                                    data: [
                                        {y: 0, color: "#eca865"},
                                        {y: 0, color: gendercolors},
                                        {y: 0, color: "#e6d94c"}
                                    ],
                                    showInLegend: false
                                }],
                                plotOptions: {
                                    series: {
                                        dataLabels: {
                                            align: 'left',
                                            enabled: true
                                        }
                                    }
                                }
                            });
                            chart.update({
                                chart: {inverted: true, polar: false},
                                subtitle: {text: ''}
                            });


                            $(".character-text-left").find("#personalData").find("span").on("click", function () {

                                var chart = Highcharts.chart('RunData', {
                                    title: {text: ''},
                                    subtitle: {text: ''},
                                    xAxis: {categories: [s[0].age, s[0].gender, s[0].race, s[0].loyalty]},
                                    bar: {dataLabels: {enabled: true}},
                                    series: [{
                                        name: 'Number',
                                        type: 'column',
                                        colorByPoint: true,
                                        data: [
                                            {y: 0, color: "#eca865"},
                                            {y: 0, color: gendercolors},
                                            {y: 0, color: "#e6d94c"}
                                        ],
                                        showInLegend: false
                                    }],
                                    plotOptions: {
                                        series: {
                                            dataLabels: {
                                                align: 'left',
                                                enabled: true
                                            }
                                        }
                                    }
                                });
                                chart.update({
                                    chart: {inverted: true, polar: false},
                                    subtitle: {text: ''}
                                });




                                var index=$(this).index()-1;
                                var image=$("#personalData").find("img").attr("src");
                                var originImgWidth ;
                                var originImgHeigh ;

                                getImageWidth(image,function(w,h){
                                    return originImgWidth = w ,
                                        originImgHeigh = h;
                                });



                                var imgsX=imgLeft[index]*originImgWidth/100.0;
                                var imgsY=imgTop[index]*originImgHeigh/100.0;
                                var imgsWidth=imgWidth[index]*originImgWidth/100.0;
                                var imgsHeight=imgHeight[index]*originImgHeigh/100.0;

                                function drawBeauty(image){
                                    var mycv = document.getElementById("myCanvas");
                                    var myctx = mycv.getContext("2d");
                                    myctx.clearRect(0,0,canvas.width,canvas.height);
                                    myctx.drawImage(image,
                                        imgsX,
                                        imgsY,
                                        imgsWidth,
                                        imgsHeight,
                                        0,
                                        0,
                                        300,
                                        162
                                    );
                                }
                                function load(){
                                    var beauty = new Image();
                                    beauty.src = image;
                                    if(beauty.complete){
                                        drawBeauty(beauty);

                                    }else{
                                        beauty.onload = function(){
                                            drawBeauty(beauty);
                                        };
                                        beauty.onerror = function(){
                                        };
                                    }
                                }

                                load();
                                function getImageWidth(url,callback){
                                    var img = new Image();
                                    img.src = url;
                                    if(img.complete){
                                        callback(img.width, img.height);
                                    }else{
                                        img.onload = function(){
                                            callback(img.width, img.height);
                                        }
                                    }
                                }
                                $(this).addClass("PersonalDetails").siblings().removeClass("PersonalDetails");
                                var indexs = $(this).index() - 1;
                                var gageconf = Number(s[indexs].age_conf).toFixed(2);
                                var ggenderconf = Number(s[indexs].gender_conf).toFixed(2);
                                var grececonf = Number(s[indexs].race_conf).toFixed(2);
                                var gloyaltyconf = Number(s[indexs].loyalty_conf).toFixed(2);
                                var gageValue = 0, ggenderValue = 0, graceValue = 0, gloyaltyValue = 0;
                                $.each(data.list, function (j, m) {
                                    if (m.author.average == 0) {gageValue = 0;} else {gageValue = gageconf;}
                                    if (m.author.gender == 0) {ggenderValue = 0;} else {ggenderValue = ggenderconf;}
                                    if (m.author.loyalty == 0) {graceValue = 0} else {graceValue = grececonf}
                                });
                                var chart = Highcharts.chart('RunData', {
                                    title: {text: ''},
                                    subtitle: {text: ''},
                                    xAxis: {categories: [s[indexs].age, s[indexs].gender, s[indexs].race, s[indexs].loyalty]},
                                    bar: {dataLabels: {enabled: true}},
                                    series: [{
                                        name: 'Number',
                                        type: 'column',
                                        colorByPoint: true,
                                        data: [{y: Number(gageValue), color: "#9ae06e"},
                                            {y: Number(ggenderValue), color: "#f05123"},
                                            {y: Number(graceValue), color: "#0a5e8b"}
                                        ],
                                        showInLegend: false
                                    }],
                                    plotOptions: {
                                        series: {
                                            dataLabels: {
                                                align: 'left',
                                                enabled: true
                                            }
                                        }
                                    }
                                });
                                chart.update({
                                    chart: {
                                        inverted: true,
                                        polar: false
                                    },
                                    subtitle: {
                                        text: ''
                                    }
                                });

                            });
                        });
                        var size = $(".character-text-left").find("div").find("span").size();
                        $(".character-text-left").find("#GroupNumber").html(size+"  people detected");
                        /*****************年龄的本分比（age Percentage）**********************/
                        if (gByTwentyFive != 0) {gByTwentyFive = (gByTwentyFive / size) * 100}
                        if (gByThirty != 0) {gByThirty = (gByThirty / size) * 100}
                        if (gByThirtyFive != 0) {gByThirtyFive = (gByThirtyFive / size) * 100}
                        if (gByForty != 0) {gByForty = (gByForty / size) * 100}
                        if (gByFortyFive != 0) {gByFortyFive = (gByFortyFive / size) * 100}
                        if (gByFifty != 0) {gByFifty = (gByFifty / size) * 100}
                        if (gByFiftyFive != 0) {gByFiftyFive = (gByFiftyFive / size) * 100}
                        if (gBySixty != 0) {gBySixty = (gBySixty / size) * 100}
                        if (gagetwenty != 0) {gagetwenty = (gagetwenty / size) * 100}
                        if (gthanSixty != 0) {gthanSixty = (gthanSixty / size) * 100}
                        $('#circularAge').highcharts({
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                backgroundColor: "#fff"
                            },
                            title: {text: ''},
                            tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: false, format: '{point.percentage:.1f} %',
                                        distance: -10, connectorPadding: 0
                                    },
                                    colors: ["#d3f2c1", "#ade58a", "#9ae06e", "#78d43b", "#64c020", "#5ab01c",
                                        "#519e1a", "#488d17", "#346710", "#204109"]
                                }
                            },
                            series: [{
                                type: 'pie',
                                name: 'Number',
                                data: [
                                    ['0-20', gagetwenty],
                                    ['20-25', gByTwentyFive],
                                    ['25-30', gByThirty],
                                    ['30-35', gByThirtyFive],
                                    ['35-40', gByForty],
                                    ['40-45', gByFortyFive],
                                    ['45-50', gByFifty],
                                    ['50-55', gByFiftyFive],
                                    ['55-60', gBySixty],
                                    ['>60', gthanSixty]
                                ]
                            }]
                        });
                        /*******************种族的半分比（ race Percentage）********************************/
                        if (gCaucasian != 0) {gCaucasian = (gCaucasian / size) * 100}
                        if (gAfrica != 0) {gAfrica = (gAfrica / size) * 100}
                        if (gAsian != 0) {gAsian = (gAsian / size) * 100}
                        if (gHispanic != 0) {gHispanic = (gHispanic / size) * 100}
                        $('#circularEthnicity').highcharts({
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                backgroundColor: "#fff"
                            },
                            title: {text: ''},
                            tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: false,
                                        format: '{point.percentage:.1f} %',
                                        distance: -10,
                                        connectorPadding: 0
                                    },
                                    colors: ["#c3e4f7", "#77c4ed", "#1f8bc4", "#0a5e8b"]
                                }
                            },
                            series: [{
                                type: 'pie',
                                name: 'Number',
                                data: [
                                    ['Caucasian', gCaucasian],
                                    ['Africa', gAfrica],
                                    ['Asian', gAsian],
                                    ['Hispanic', gHispanic]
                                ]
                            }]
                        });

                        /*****************性别的半分比（Gender Percentage）**********************/
                        if (gfemales != 0) {gfemales = (gfemales / size) * 100}
                        if (gmen != 0) {gmen = (gmen / size) * 100}
                        $('#circularGender').highcharts({
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                backgroundColor: "#fff"
                            },
                            title: {
                                text: ''
                            },
                            tooltip: {
                                pointFormat: '{series.name}:<b>{point.percentage:.1f}%</b>'
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: false,
                                        format: '{point.percentage:.1f} %',
                                        distance: -10,
                                        connectorPadding: 0
                                    },
                                    colors: ["#f05123", "#ff9e1a"]
                                }
                            },
                            series: [{
                                type: 'pie',
                                name: 'Number',
                                data: [
                                    ['men', gmen],
                                    ['females', gfemales]

                                ]
                            }]
                        });
                        //$(".character-text-left").find("div").find("span").eq(0).addClass("PersonalDetails");
                        /*==============判断是否有========================*/
                        $.each(data.list, function (j, m) {
                            /***********判断是否有年龄******************/
                            if (m.author.average == 0) {
                                $('#circularAge').highcharts({
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        backgroundColor: "#fff"
                                    },
                                    title: {text: ''},
                                    tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: false, format: '{point.percentage:.1f} %',
                                                style: {
                                                    "color": "#fff",
                                                    "fontSize": "6px",
                                                    "textOutline": "1px 1px contrast"
                                                },
                                                distance: -10, connectorPadding: 0
                                            },
                                            colors: ["#f0d6a4", "#f8c35e", "#f7b63a", "#e49909", "#cd8907", "#b47805",
                                                "#a16b04", "#8a5b02", "#764f03", "#5c3f06"]
                                        }
                                    },
                                    series: [{
                                        type: 'pie',
                                        name: 'Number',
                                        data: [
                                            ['0-20', 0],
                                            ['20-25', 0],
                                            ['25-30', 0],
                                            ['30-35', 0],
                                            ['35-40', 0],
                                            ['40-45', 0],
                                            ['45-50', 0],
                                            ['50-55', 0],
                                            ['55-60', 0],
                                            ['>60', 0]
                                        ]
                                    }]
                                });
                            }
                            /***********判断是否有性别******************/
                            if (m.author.gender == 0) {
                                $('#circularGender').highcharts({
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        backgroundColor: "#fff"
                                    },
                                    title: {
                                        text: ''
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}:<b>{point.percentage:.1f}%</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: false,
                                                format: '{point.percentage:.1f} %',
                                                style: {
                                                    "color": "#fff",
                                                    "fontSize": "6px",
                                                    "textOutline": "1px 1px contrast"
                                                },
                                                distance: -10,
                                                connectorPadding: 0
                                            },
                                            colors: ["#2e9dd9", "#de443c"]
                                        }
                                    },
                                    series: [{
                                        type: 'pie',
                                        name: 'Number',
                                        data: [
                                            ['men', 0],
                                            ['females', 0]

                                        ]
                                    }]
                                });
                            }
                            /***********判断是否有种族******************/
                            if (m.author.race == 0) {
                                $('#circularEthnicity').highcharts({
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        backgroundColor: "#fff"
                                    },
                                    title: {text: ''},
                                    tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: false,
                                                format: '{point.percentage:.1f} %',
                                                style: {
                                                    "color": "#fff",
                                                    "fontSize": "6px",
                                                    "textOutline": "1px 1px contrast"
                                                },
                                                distance: -10,
                                                connectorPadding: 0
                                            },
                                            colors: ["#e2e2e2", "#565553", "#ece165", "#81511c"]
                                        }
                                    },
                                    series: [{
                                        type: 'pie',
                                        name: 'Number',
                                        data: [
                                            ['Caucasian', 0],
                                            ['Africa', 0],
                                            ['Asian', 0],
                                            ['Hispanic', 0]
                                        ]
                                    }]
                                });
                            }

                        });
                    });
                    // 选中图片相应的数据
                    $(".selected").on("click", function () {
                        /**************添加数据*************************/
                        var indexs = [];
                        $("[name=checkboxt]").each(function () {
                            if ($(this).prop("checked") == true) {
                                indexs.push($(this).parent().index());
                            }
                        });
                        if(indexs == 0){
                            return false;
                        }
                        /*************添加样式******************/
                        $(".details-picture").css({display: "block"});
                        var imgH = $(".details-text").height();
                        var dH = ($(window).height() - imgH) / 2;
                        var dW = ($(window).width() - 1180) / 2;
                        $(".details-text").css({left: dW, top: dH});
                        $(".details-Close").on("click", function () {
                            $(".details-picture").css({display: "none"})
                        });

                        var tfemales = 0, tmen = 0, tCaucasian = 0, tAfrica = 0, tAsian = 0, tHispanic = 0, tByTwentyFive = 0,
                            tByThirty = 0, ttByThirtyFive = 0, tByForty = 0,
                            tByFortyFive = 0, tByFifty = 0, tByFiftyFive = 0, tBySixty = 0, tagetwenty = 0, tthanSixty = 0;
                        $.each(indexs, function (n, l) {
                            $.each(data.list_a[l], function (n, t) {
                                $.each(t, function (k, m) {
                                    if (m.gender == "female") {tfemales = tfemales + 1;}
                                    if (m.gender == "male") {tmen = tmen + 1;}
                                    if (m.race == "Caucasian") {tCaucasian = tCaucasian + 1;}
                                    if (m.race == "African") {tAfrica = tAfrica + 1;}
                                    if (m.race == "Asian") {tAsian = tAsian + 1;}
                                    if (m.race == "Hispanic") {tHispanic = tHispanic + 1;}
                                    if (m.age == "20-25") {tByTwentyFive = tByTwentyFive + 1}
                                    if (m.age == "25-30") {tByThirty = tByThirty + 1}
                                    if (m.age == "30-35") {ttByThirtyFive = ttByThirtyFive + 1}
                                    if (m.age == "35-40") {tByForty = tByForty + 1}
                                    if (m.age == "40-45") {tByFortyFive = tByFortyFive + 1}
                                    if (m.age == "45-50") {tByFifty = tByFifty + 1}
                                    if (m.age == "50-55") {tByFiftyFive = tByFiftyFive + 1}
                                    if (m.age == "55-60") {tBySixty = tBySixty + 1}
                                    if (m.age == "0-20") {tagetwenty = tagetwenty + 1}
                                    if (m.age == ">60") {tthanSixty = tthanSixty + 1}
                                })
                            })
                        });
                        var size = tmen + tfemales;
                        $("#detailsCharacterNumber").html(size);
                        // 统计选中图片的年龄数（age）
                        Highcharts.chart('selectedAge', {
                            title: {text: 'Age'},
                            subtitle: {text: ''},
                            xAxis: {
                                categories: ['<20', '20-25', '25-30', '30-35', '35-40', '40-45', '45-50', '50-55', '55-60', '>60'],
                                labels: {rotation: 90, style: {fontSize: '12px', fontFamily: 'Verdana, sans-serif'}}
                            },
                            yAxis: {labels: {step: 1}},
                            series: [{
                                name: 'Number',
                                type: 'column',
                                colorByPoint: true,
                                data: [
                                    {y: tagetwenty, color: "#d3f2c1"},
                                    {y: tByTwentyFive, color: "#ade58a"},
                                    {y: tByThirty, color: "#9ae06e"},
                                    {y: ttByThirtyFive, color: "#78d43b"},
                                    {y: tByForty, color: "#64c020"},
                                    {y: tByFortyFive, color: "#5ab01c"},
                                    {y: tByFifty, color: "#519e1a"},
                                    {y: tByFiftyFive, color: "#488d17"},
                                    {y: tBySixty, color: "#346710"},
                                    {y: tthanSixty, color: "#204109"}],
                                showInLegend: false
                            }]
                        });
                        // 统计选中图片的性别数（cender）
                        Highcharts.chart('selectedGender', {
                            title: {text: 'Gender'},
                            subtitle: {text: ''},
                            xAxis: {
                                categories: ['men', 'female'],
                                labels: {rotation: 0, style: {fontSize: '12px', fontFamily: 'Verdana, sans-serif'}}
                            },
                            yAxis: {labels: {step: 1}},
                            series: [{
                                name: 'Number',
                                type: 'column',
                                colorByPoint: true,
                                data: [
                                    {y: tmen, color: "#f05123"},
                                    {y: tfemales, color: "#ff9e1a"}
                                ],
                                showInLegend: false
                            }]
                        });
                        // 统计选中图片的种族数（race）
                        Highcharts.chart('selectedRace', {
                            title: {text: 'Race'},
                            subtitle: {text: ''},
                            xAxis: {
                                categories: ['Asian', 'Hispanic', 'Africa', 'Caucasian'],
                                labels: {rotation: 0, style: {fontSize: '12px', fontFamily: 'Verdana, sans-serif'}}
                            },
                            yAxis: {labels: {step: 1}},
                            series: [{
                                name: 'Number',
                                type: 'column',
                                colorByPoint: true,
                                data: [
                                    {y: tAsian, color: "#c3e4f7"},
                                    {y: tHispanic, color: "#77c4ed"},
                                    {y: tAfrica, color: "#1f8bc4"},
                                    {y: tCaucasian, color: "#0a5e8b"}
                                ],
                                showInLegend: false
                            }]
                        });

                        /*==============判断是否有========================*/
                        $.each(data.list, function (j, m) {
                            // 判断是否有年龄
                            if (m.author.average == 0) {
                                Highcharts.chart('selectedAge', {
                                    title: {text: 'Age'},
                                    subtitle: {text: ''},
                                    xAxis: {
                                        categories: ['<20', '20-25', '25-30', '30-35', '35-40', '40-45', '45-50', '50-55', '55-60', '>60'],
                                        labels: {
                                            rotation: 90,
                                            style: {fontSize: '12px', fontFamily: 'Verdana, sans-serif'}
                                        }
                                    },
                                    yAxis: {labels: {step: 1}},
                                    series: [{
                                        name: 'Number',
                                        type: 'column', colorByPoint: true,
                                        data: [
                                            {y: 0, color: "#d3f2c1"},
                                            {y: 0, color: "#ade58a"},
                                            {y: 0, color: "#9ae06e"},
                                            {y: 0, color: "#78d43b"},
                                            {y: 0, color: "#64c020"},
                                            {y: 0, color: "#5ab01c"},
                                            {y: 0, color: "#519e1a"},
                                            {y: 0, color: "#488d17"},
                                            {y: 0, color: "#346710"},
                                            {y: 0, color: "#204109"}],
                                        showInLegend: false
                                    }]
                                });
                            }
                            // 判断是否有性别
                            if (m.author.gender == 0) {
                                Highcharts.chart('selectedGender', {
                                    title: {text: 'Gender'},
                                    subtitle: {text: ''},
                                    xAxis: {
                                        categories: ['men', 'female'],
                                        labels: {
                                            rotation: 0,
                                            style: {fontSize: '12px', fontFamily: 'Verdana, sans-serif'}
                                        }
                                    },
                                    yAxis: {labels: {step: 1}},
                                    series: [{
                                        name: 'Number',
                                        type: 'column', colorByPoint: true,
                                        data: [
                                            {y: 0, color: "#f05123"},
                                            {y: 0, color: "#ff9e1a"}
                                        ],
                                        showInLegend: false
                                    }]
                                });
                            }
                            // 判断是否有忠诚度
                            /*   if (m.author.loyalty == 0) {
                             Highcharts.chart('loyalty', {
                             title: {text: 'Loyalty'},
                             subtitle: {text: ''},
                             xAxis: {
                             categories: ['low', 'middle', 'high'],
                             labels: {
                             rotation: 0,
                             style: {
                             fontSize: '12px',
                             fontFamily: 'Verdana, sans-serif'
                             }
                             }
                             },
                             yAxis: {labels: {step: 1}},
                             series: [{
                             type: 'column',
                             colorByPoint: true,
                             data: [
                             {y: 0, color: "#99e4cb"}, {y: 0, color: "#58e2b4"}, {y: 0, color: "#0af0a3"}
                             ],
                             showInLegend: false
                             }]
                             });
                             }*/
                            // 判断是否有种族
                            if (m.author.race == 0) {
                                Highcharts.chart('selectedRace', {
                                    title: {text: 'Race'},
                                    subtitle: {text: ''},
                                    xAxis: {
                                        categories: ['Asian', 'Hispanic', 'Africa', 'Caucasian'],
                                        labels: {
                                            rotation: 0,
                                            style: {fontSize: '12px', fontFamily: 'Verdana, sans-serif'}
                                        }
                                    },
                                    yAxis: {labels: {step: 1}},
                                    series: [{
                                        name: 'Number',
                                        type: 'column',
                                        colorByPoint: true,
                                        data: [
                                            {y: 0, color: "#c3e4f7"},
                                            {y: 0, color: "#77c4ed"},
                                            {y: 0, color: "#1f8bc4"},
                                            {y: 0, color: "#0a5e8b"}
                                        ],
                                        showInLegend: false
                                    }]
                                });
                            }
                        });
                    });
                    // 所有的图片数据
                    $.each(data.list_a, function (k, y) {
                        $.each(y.face, function (s, z) {
                            if (z.gender == "female") {females = females + 1;}
                            if (z.gender == "male") {men = men + 1;}
                            if (z.loyalty == "low") {low = low + 1;}
                            if (z.loyalty == "middle") {middle = middle + 1;}
                            if (z.loyalty == "high") {high = high + 1;}
                            if (z.race == "Caucasian") {Caucasian = Caucasian + 1;}
                            if (z.race == "African") {Africa = Africa + 1;}
                            if (z.race == "Asian") {Asian = Asian + 1;}
                            if (z.race == "Hispanic") {Hispanic = Hispanic + 1;}
                            if (z.age == "20-25") {ByTwentyFive = ByTwentyFive + 1}
                            if (z.age == "25-30") {ByThirty = ByThirty + 1}
                            if (z.age == "30-35") {ByThirtyFive = ByThirtyFive + 1}
                            if (z.age == "35-40") {ByForty = ByForty + 1}
                            if (z.age == "40-45") {ByFortyFive = ByFortyFive + 1}
                            if (z.age == "45-50") {ByFifty = ByFifty + 1}
                            if (z.age == "50-55") {ByFiftyFive = ByFiftyFive + 1}
                            if (z.age == "55-60") {BySixty = BySixty + 1}
                            if (z.age == "0-20") {agetwenty = agetwenty + 1}
                            if (z.age == ">60") {thanSixty = thanSixty + 1}
                        })
                    });
                    // 年龄 age
                    Highcharts.chart('detailsAge', {

                        title: {text: ''},
                        subtitle: {text: ''},
                        xAxis: {
                            categories: ['<20', '20-25', '25-30', '30-35', '35-40', '40-45', '45-50', '50-55', '55-60', '>60'],
                            labels: {rotation: 90, style: {fontSize: '12px', fontFamily: 'Verdana, sans-serif'}}
                        },
                        yAxis: {
                            allowDecimals: false
                        },
                        series: [{
                            name: 'Number',
                            type: 'column',
                            colorByPoint: true,
                            data: [
                                {y: agetwenty, color: "#d3f2c1"},
                                {y: ByTwentyFive, color: "#ade58a"},
                                {y: ByThirty, color: "#9ae06e"},
                                {y: ByThirtyFive, color: "#78d43b"},
                                {y: ByForty, color: "#64c020"},
                                {y: ByFortyFive, color: "#5ab01c"},
                                {y: ByFifty, color: "#519e1a"},
                                {y: ByFiftyFive, color: "#488d17"},
                                {y: BySixty, color: "#346710"},
                                {y: thanSixty, color: "#204109"}
                            ],
                            showInLegend: false
                        }]
                    });
                    // 性别 gender
                    $('#gender').highcharts({
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            backgroundColor: "#fff"
                        },
                        title: {text: ''},
                        tooltip: {pointFormat: '<b>{point.percentage:.1f}%</b>'},
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: false,
                                    format: '{point.percentage:.1f} %',
                                    style: {
                                        "color": "#fff", "fontSize": "6px", "textOutline": "1px 1px contrast"
                                    },
                                    distance: -10,
                                    connectorPadding: 0
                                },
                                colors: ["#f05123", "#ff9e1a"]
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: 'Number',
                            data: [
                                ['Male', men],
                                ['Female', females]

                            ]
                        }]
                    });
                    // 种族 Race
                    Highcharts.chart('race', {
                        title: {text: ''},
                        subtitle: {text: ''},
                        xAxis: {
                            categories: ['Asian', 'Hispanic', 'Africa', 'Caucasian'],
                            labels: {rotation: 0, style: {fontSize: '12px', fontFamily: 'Verdana, sans-serif'}}
                        },
                        yAxis: {labels: {step: 1}},
                        series: [{
                            name: 'Number',
                            type: 'column',
                            colorByPoint: true,
                            data: [
                                {y: Asian, color: "#c3e4f7"},
                                {y: Hispanic, color: "#77c4ed"},
                                {y: Africa, color: "#1f8bc4"},
                                {y: Caucasian, color: "#0a5e8b"}
                            ],
                            showInLegend: false
                        }]
                    });
                    // 忠诚度 loyalty
                    /*  Highcharts.chart('loyalty', {
                     title: {text: 'Loyalty'},
                     subtitle: {text: ''},
                     xAxis: {
                     categories: ['low', 'middle', 'high'],
                     labels: {
                     rotation: 0,
                     style: {
                     fontSize: '12px',
                     fontFamily: 'Verdana, sans-serif'
                     }
                     }
                     },
                     yAxis: {labels: {step: 1}},
                     series: [{
                     type: 'column',
                     colorByPoint: true,
                     data: [
                     {y: low, color: "#99e4cb"}, {y: middle, color: "#58e2b4"}, {y: high, color: "#0af0a3"}
                     ],
                     showInLegend: false
                     }]
                     });*/
                    // 循环判断是否有数据
                    $.each(data.list, function (j, m) {
                        // 判断是否有年龄
                        if (m.author.average == 0) {
                            Highcharts.chart('detailsAge', {
                                title: {text: ''},
                                subtitle: {text: ''},
                                xAxis: {
                                    categories: ['<20', '20-25', '25-30', '30-35', '35-40', '40-45', '45-50', '50-55', '55-60', '>60'],
                                    labels: {rotation: 90, style: {fontSize: '12px', fontFamily: 'Verdana, sans-serif'}}
                                },
                                yAxis: {labels: {step: 1}},
                                series: [{
                                    name: 'Number',
                                    type: 'column',
                                    colorByPoint: true,
                                    data: [
                                        {y: 0, color: "#f0d6a4"},
                                        {y: 0, color: "#f8c35e"},
                                        {y: 0, color: "#f7b63a"},
                                        {y: 0, color: "#e49909"},
                                        {y: 0, color: "#cd8907"},
                                        {y: 0, color: "#b47805"},
                                        {y: 0, color: "#a16b04"},
                                        {y: 0, color: "#8a5b02"},
                                        {y: 0, color: "#764f03"},
                                        {y: 0, color: "#5c3f06"}
                                    ],
                                    showInLegend: false
                                }]
                            });
                        }
                        // 判断是否有性别
                        if (m.author.gender == 0) {

                            $('#gender').highcharts({
                                chart: {
                                    plotBackgroundColor: null,
                                    plotBorderWidth: null,
                                    plotShadow: false,
                                    backgroundColor: "#fff"
                                },
                                title: {text: ''},
                                tooltip: {pointFormat: '<b>{point.percentage:.1f}%</b>'},
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        borderWidth: 0,
                                        dataLabels: {
                                            enabled: false,
                                            format: '{point.percentage:.1f} %',
                                            style: {
                                                "color": "#fff", "fontSize": "6px", "textOutline": "1px 1px contrast"
                                            },
                                            distance: -10,
                                            connectorPadding: 0
                                        },
                                        colors: ["#f05123", "#ff9e1a"]
                                    }
                                },
                                series: [{
                                    type: 'pie',
                                    name: 'Number',
                                    data: [
                                        ['Male', 0],
                                        ['Female', 0]

                                    ]
                                }]
                            });
                        }
                        // 判断是否有种族
                        if (m.author.race == 0) {
                            Highcharts.chart('race', {
                                title: {text: ''},
                                subtitle: {text: ''},
                                xAxis: {
                                    categories: ['Asian', 'Hispanic', 'Africa', 'Caucasian'],
                                    labels: {rotation: 0, style: {fontSize: '12px', fontFamily: 'Verdana, sans-serif'}}
                                },
                                yAxis: {labels: {step: 1}},
                                series: [{
                                    name: 'Number',
                                    type: 'column', colorByPoint: true,
                                    data: [
                                        {y: 0, color: "#c3e4f7"},
                                        {y: 0, color: "#77c4ed"},
                                        {y: 0, color: "#1f8bc4"},
                                        {y: 0, color: "#0a5e8b"}
                                    ],
                                    showInLegend: false
                                }]
                            });
                        }
                        /*/!***********判断是否有忠诚度******************!/
                         if (m.author.loyalty == 0) {
                         Highcharts.chart('loyalty', {
                         title: {text: 'Loyalty'},
                         subtitle: {text: ''},
                         xAxis: {
                         categories: ['low', 'middle', 'high'],
                         labels: {
                         rotation: 0,
                         style: {
                         fontSize: '12px',
                         fontFamily: 'Verdana, sans-serif'
                         }
                         }
                         },
                         yAxis: {labels: {step: 1}},
                         series: [{
                         type: 'column',
                         colorByPoint: true,
                         data: [
                         {y: 0, color: "#99e4cb"}, {y: 0, color: "#58e2b4"}, {y: 0, color: "#0af0a3"}
                         ],
                         showInLegend: false
                         }]
                         });
                         }*/
                    });
                    var imgNumber= $(".details-center-left-text").find("li").size();
                    var allCharacterNumber = females+men;
                    var RepeatCharacters = low + middle;
                    $("#allImageNumber").text(imgNumber);
                    $("#allCharacterNumber").text(allCharacterNumber);
                    $("#NoRepeatCharacters").text(high);
                    $("#RepeatCharacters").text(RepeatCharacters);
                },
                error: function () {
                    alert("Failed to load")
                }
            });

        });


    </script>
@stop