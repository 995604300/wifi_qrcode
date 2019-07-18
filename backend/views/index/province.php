<?php

/* @var $this yii\web\View */

$this->title = '首页';
$this->params['breadcrumbs'][] = '总览';

?>
<?php
$css = <<<Css

        body{
            position: relative;
            background-color: #000000;
        }
        *{
             margin: 0;
             padding: 0;
             box-sizing: border-box;
         }
        ul,li{
            list-style: none;
        }
        .clear:after{
            display: block;
            content: "";
            clear:both;
        }
 
        #mainleft,#mainright{
            float:left;
            height: 85%;
            margin-top: -60px;
        }
        #mainleft{
            width:63%;
        }
        #mapchart{
            width: 100%;
            height: 100%;
        }
 
        /*悬浮框*/
        #plan{
            margin: 10px;
            background-color: #011C31;
            border-top: 1px solid #27BFC4;
            border-left: 1px solid #27BFC4;
            font-size: 12px;
            color: #fff;
            width: 200px;
        }
        #plan li{
            height: 20px;
            padding-left: 10px;
            border-bottom: 1px solid #27BFC4;
 
        }
        #plan li:first-child{
            font-size: 14px;
            height: 22px;
        }
        #plan li:first-child img{
            width: 10px;
            display: inline-block;
            margin:4px 4px 0 -4px;
        }
        #plan li span{
            display: inline-block;
        }
        #plan li span:first-child{
            width: 70px;
        }
        #plan li span:nth-child(2){
            width: 60px;
        }
        #plan li span:nth-child(3){
            width: 50px;
        }
        /*排行榜*/
        #mainright{
            width: 37%;
        }
        #mainright{
            padding: 10px;
        }
        #rank{
            background-color: rgba(119,119,119,.3);
            width:98%;
            height: 94%;
            color: white;
            position: relative;
        }
        #rank li p{
            float: left;
        }
        /*四个角*/
        #rank>li.corner>p{
            width: 16px;
            height: 16px;
        }
        #rank>li:first-child>p:first-child{
            float: left;
            border-top: 1px solid #27BFC4;
            border-left: 1px solid #27BFC4;
        }
        #rank>li:first-child>p:last-child{
            float: right;
            border-top: 1px solid #27BFC4;
            border-right: 1px solid #27BFC4;
        }
        #rank>li.corner:last-child{
            position: absolute;
            bottom:0;
            width: 100%;
        }
        #rank>li:last-child>p:first-child{
             float: left;
             border-bottom: 1px solid #27BFC4;
             border-left: 1px solid #27BFC4;
         }
        #rank>li:last-child>p:last-child{
            float: right;
            border-bottom: 1px solid #27BFC4;
            border-right: 1px solid #27BFC4;
        }
        /*排行榜主体*/
        #rank>li.thead{
            margin-bottom: 8px;
        }
        #rank>li.tobdy:hover{
            background-color: rgba(255,255,255,.2);
        }
        #rank>li.tobdy{
            height: 9.3%;
            padding-top: 10px;
        }
        #rank>li.tobdy>p:first-child{
            width: 20%;
        }
        #rank>li.tobdy>p:first-child span{
            display: block;
            width:20px;
            height: 20px;
            text-align: center;
            background-color: #27BFC4;
            margin:auto;
            color: #FFFFFF;
        }
        
        #rank>li.tobdy>p:nth-child(2){
            width: 25%;
        }
        #rank p.prog-bg,#rank p.prog-on{
            height: 4px;
            border-radius:4px;
        }
        #rank p.prog-bg {
            width: 100%;
            margin-top: 4px;
            background-color: rgba(119,119,119,.5);
        }
        #rank p.prog-on{
            background-color: #95BA2E;
            margin-top: -4px;
        }
      
        .total-left{
            float:left;
            color:#40E0D0;
            font-size: 19px;
            margin-left: 40px;
        }
        .total-right{
            float:right;
            color:#40E0D0;
            font-size: 19px;
            margin-right: 40px;
        }
        div .val{
            text-align: center;
            line-height: 25px;
            width: 25px;
            height: 25px;;
            display: inline-block;
            border: 3px dashed;
            border-block-end:dashed;
            /* border-block-end-color:#98FB98; */
            margin-top: 10px;
            margin-left: 10px;
        }
        div span:nth-child(1){
            color: #27BFC4;
        }
Css;
$this->registerCss($css)
?>
<html lang="en"  style="height: 100%">
<head>
    <meta charset="UTF-8">
</head>

<!--<script src="/js/plugins/echarts/echarts-all.js"></script>-->
<script src="/js/plugins/echarts/echarts.min.js"></script>
<body style="height: 100%; margin-top: 50px;min-width: 1200px;min-height: 770px">

<div style="height: 10%;"></div>
<div id="mainleft">
    <div id="mapchart"></div>
</div>
<?php if (isset($data)): ?>
<div id="mainright">
    <ul id="rank">
        <li class="corner clear">
            <p></p>
            <p></p>
        </li>
        <li class="thead clear">
            <p style="width: 20%;text-align: center">排行</p>
            <p style="width: 25%;text-align: center">地区</p>
            <p style="width: 55%;text-align: center">扫码次数</p>
        </li>
        <?php
        foreach ($data as $key=>$val) {
            if ($key>9){
                break;
            } else{
                echo "<li class='tobdy clear'>
                    <p style='text-align: center'>
                      <span>".($key+1)." </span>
                    </p>
                    <p style='text-align: center'>".$val['name']."</p>
                    <div class='prog' style='text-align: center'>
                      <ul class='clear'>
                        <li>".$val['value']." 次</li>
                      </ul>
                    </div>
                  </li>";
            }
        }
        ?>
        <li class="corner clear">
            <p></p>
            <p></p>
        </li>
    </ul>
</div>
<?php endif; ?>
</body>
<script>
    //https://github.com/apache/incubator-echarts/tree/master/map
    //这个地址可以下载到地图文件
    $(function () {
        var pName = "<?= $province;?>";
        loadBdScript('$'+pName+'JS','/js/plugins/echarts/js/'+pName+'.js',function() {
            initProvince("<?=$province_name?>");
        });
        function  initProvince(Chinese_){
            var provinceMap = echarts.init(document.getElementById('mapchart'));
            provinceMap.showLoading();

            provinceMap.hideLoading();

            provinceMap.setOption(option = {
                tooltip: {
                    trigger: "item",
                    // alwaysShowContent:true,
                    position: function (point, params, dom, rect, size) {

                        $(dom).html();
                        // return ['2%', '70%'];//固定浮框的位置
                    }
                },
                roamController: {
                    x: "right",
                    mapTypeControl: {
                        china: true
                    }
                },
                visualMap: {
                    min: 0,
                    max: 500,
                    show: false,
                    splitNumber: 5,
                    inRange: {
                        color: ['#d94e5d', '#eac736', '#50a3ba'].reverse()
                    },
                    textStyle: {
                        color: '#fff'
                    }
                },
                series:{
                    map: Chinese_,
                    name: "连接次数",
                    type: "map",
                    // roam:true,//支持鼠标缩放和移动
                    mapType: "china",
                    mapValueCalculation: "sum",
                    label: {//图形上的文本标签,拥有label的一系列属性
                        // show: true
                    },
                    emphasis: {//高亮状态下的样式
                        label: {
                            show: true
                        },
                        itemStyle:{
                            areaColor:'#FEF200',
                            borderColor:'#D8B915',
                            borderWidth:2
                        },
                    },
                    itemStyle: {
                        color: function (params) {
                            if (params.value < 2000)
                            {
                                return '#65CAD4'
                            }
                            else if (params.value > 2000 && params.value <= 4000)
                            {
                                return '#28BFC8'
                            }
                            else if (params.value > 4000 && params.value <= 6000)
                            {
                                return '#24B4B5'
                            }
                            else if (params.value > 6000 && params.value <= 8000)
                            {
                                return '#2E999F'
                            }
                            else if (params.value > 8000)
                            {
                                return '#25677F'
                            }
                        }
                    },
                    data: <?= json_encode($data)?>

                }
            });

            provinceMap.on('click', function (param) {
                window.location.href = "welcome";
            });

            $('li.tobdy').mouseenter(function () {
                var thisIndex = $(this).index() - 2;//同辈的最前面还有两个li
                // $.each(data,function (i) {
                //     data[i].selected = false;
                // });
                // data[thisIndex].selected = true;
                // map.setOption(option);
                provinceMap.dispatchAction({
                    type: 'mapSelect',
                    seriesIndex: 0,
                    dataIndex: thisIndex
                });

                provinceMap.dispatchAction({
                    type: 'showTip',
                    seriesIndex: 0,
                    dataIndex: thisIndex
                });
            });

            $('li.tobdy').mouseleave(function () {
                var thisIndex = $(this).index() - 2;
                // data[thisIndex].selected = false;
                // map.setOption(option);
                provinceMap.dispatchAction({
                    type: 'mapUnSelect',
                    seriesIndex: 0,
                    dataIndex: thisIndex
                });
                provinceMap.dispatchAction({
                    type: 'hideTip',
                    seriesIndex: 0,
                    dataIndex: thisIndex
                });
            });
        }




        window.onresize = function () {
            map.resize();
        };
        //加载对应的JS
        function loadBdScript(scriptId, url, callback) {
            var script = document.createElement("script")
            script.type = "text/javascript";
            if (script.readyState){  //IE
                script.onreadystatechange = function(){
                    if (script.readyState == "loaded" || script.readyState == "complete"){
                        script.onreadystatechange = null;
                        callback();
                    }
                };
            } else {  //Others
                script.onload = function(){
                    callback();
                };
            }
            script.src = url;
            script.id = scriptId;
            document.getElementsByTagName("head")[0].appendChild(script);
        };

    }());




</script>


