<?php
$css = <<<Css
#project{
   display: flex;
   flex-wrap: wrap;
}
.external_Typesetting{
    display: flex;
    width: 306px;
    height: 406px;
    border: 1px solid #4C9ACA;
    flex-direction: column;
    justify-content: space-between;
    margin-left: 35px;
    margin-top: 115px;


}
.head{
    width: 100%;
    height: 20%;

    display: flex
}
.head img{
    margin: auto;
    width: 70%;
    height: 80%;

}
.content{
    background-color: #4C9ACA !important;
    height:100%;
    display: flex;
    justify-content: center;
    position: relative;
}
.content img{
    display:block;
    width: 200px;
    height: 200px;
    margin: auto;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
}
.content p{
    position: absolute;
    bottom: 5px;
    display: block;
    bottom: 0px;
    color: #fff  !important;

}

.breadcrumb {
    display: none;
}

.bottom{
   background-color: #4C9ACA !important;
   height:80px;
   display: flex;
   border-top: 1px dashed #fff;
   background-size: 100%;
}
.bottom p{
    color: #fff !important;
    margin:auto;
    font-size: 16px;
}
Css;
$this->registerCss($css)
?>
<div id='project'>
<?php foreach ($data as $val) {
    echo "<div class='external_Typesetting'>
         <div class='head'>
             <img src='/img/rulaiyun-logo.png' >
         </div>
         <div class='content'>
             <img id='code' src=".$val['qrcode_path']." >
             <p class='p'>".$val['id']."</p>
         </div>
         <div class='bottom'>
             <p>用微信扫码即刻连入wifi</p>
         </div>
    </div>";
   }
    ?>

</div>
<script>


</script>
