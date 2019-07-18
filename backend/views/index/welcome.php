<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use liyunfang\pager\LinkPager;
use kartik\select2\Select2;

use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

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
    <div class="total_data" style="height: 12%">
        <div class="total-left">
            <div class="code">
                <span>场所数量：</span>
                <span class="span"><?=$wifi_count?></span>
            </div>
            <div class="code">
                <span>二维码数：</span>
                <span class="span"><?=$qrcode_count?></span>
            </div>
            <div class="code">
                <span>扫码次数：</span>
                <span class="span"><?=$qrcode_times?></span>
            </div>
        </div>
        <div class="total-right">
            <div class="code">
                <span>总二维码数：</span>
                <span class="span"><?=$all_qrcodes?></span>
            </div>
            <div class="code">
                <span>已绑定二维码数：</span>
                <span class="span"><?=$user_qrcodes?></span>
            </div>
            <div class="code">
                <span>剩余图片广告展示次数：</span>
                <span class="span"><?=$image_times?></span>
            </div>
            <div class="code">
                <span>剩余视频广告展示次数：</span>
                <span class="span"><?=$video_times?></span>
            </div>
        </div>
    </div>
</head>

<!--<script src="/js/plugins/echarts/echarts-all.js"></script>-->
<script src="/js/plugins/echarts/echarts.min.js"></script>
<script src="/js/plugins/echarts/china.js"></script>
<body style="height: 100%; margin-top: 50px;min-width: 1200px;min-height: 770px">

<div style="height: 10%;"></div>
<div id="mainleft">
    <div id="mapchart"></div>
</div>
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
<script>
    //https://github.com/apache/incubator-echarts/tree/master/map
    //这个地址可以下载到地图文件
    $(function () {
        var map = echarts.init(document.getElementById("mapchart"));
        var option = {
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
            tooltip: {
                trigger: "item",
                backgroundColor: 'opacity',
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
            series:{
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
                    color: function (params) {//seriesIndex, dataIndex, data, value
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
        };

        map.setOption(option);

        map.dispatchAction({
            type: 'showTip',//默认显示江苏的提示框
            seriesIndex: 0,//这行不能省
            dataIndex: 0
        });

        $('li.tobdy').mouseenter(function () {
            var thisIndex = $(this).index() - 2;//同辈的最前面还有两个li
            // $.each(data,function (i) {
            //     data[i].selected = false;
            // });
            // data[thisIndex].selected = true;
            // map.setOption(option);
            map.dispatchAction({
                type: 'mapSelect',
                seriesIndex: 0,
                dataIndex: thisIndex
            });

            map.dispatchAction({
                type: 'showTip',
                seriesIndex: 0,
                dataIndex: thisIndex
            });
        });

        $('li.tobdy').mouseleave(function () {
            var thisIndex = $(this).index() - 2;
            // data[thisIndex].selected = false;
            // map.setOption(option);
            map.dispatchAction({
                type: 'mapUnSelect',
                seriesIndex: 0,
                dataIndex: thisIndex
            });
            map.dispatchAction({
                type: 'hideTip',
                seriesIndex: 0,
                dataIndex: thisIndex
            });
        });

        window.onresize = function () {
            map.resize();
        };

        var provinces = ['shanghai', 'hebei','shanxi','neimenggu','liaoning','jilin','heilongjiang','jiangsu','zhejiang','anhui','fujian','jiangxi','shandong','henan','hubei','hunan','guangdong','guangxi','hainan','sichuan','guizhou','yunnan','xizang','shanxi1','gansu','qinghai','ningxia','xinjiang', 'beijing', 'tianjin', 'chongqing', 'xianggang', 'aomen', 'taiwan'];

        var provincesText = ['上海', '河北', '山西', '内蒙古', '辽宁', '吉林','黑龙江',  '江苏', '浙江', '安徽', '福建', '江西', '山东','河南', '湖北', '湖南', '广东', '广西', '海南', '四川', '贵州', '云南', '西藏', '陕西', '甘肃', '青海', '宁夏', '新疆', '北京', '天津', '重庆', '香港', '澳门', '台湾'];

        map.on('click', function (param) {
            for(var  i= 0 ; i < provincesText.length ; i++ ){
                if(param.name == provincesText[i])
                {
                    var url = "province?province=" + provinces[i] + "&name=" + provincesText[i];
                    break;
                }
            }
            if (param.data){
                window.location.href = url + "&province_id=" + param.data.province;
            } else {
                window.location.href = url;
            }
        });
    })




</script>


