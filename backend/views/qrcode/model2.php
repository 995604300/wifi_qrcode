<?php
$css = <<<Css
*{
    padding: 0;
    margin: 0;
}
#project{
   display: flex;
   flex-wrap: wrap;
}
.w{
    border: 2px solid #60A9D4;
    margin-left: 20px;
    margin-top: 85px;
    display: flex;
    flex-direction: column;
    
  
    
}
.content{
    
  
    display: flex;
    flex-direction: column;
}

.content img{
    width: 200px;
    height: 200px;
   
}
.p{
    width: 100%;
    border-top: 1px dashed #60A9D4;
    
    display: flex
}
.p span{
   
   margin: auto
}
.bottom{
    height: 30px;
    width: 100%;
    display: flex;
   
}
.bottom p{
    margin: 0 auto;
   
}
Css;
$this->registerCss($css)
?>
<div id='project'>
<?php foreach ($data as $val) {
    echo "<div class='w'> 
            <div class='content'> 
                <img id='code' src=".$val['qrcode_path']." </div> 
                <p class='p'><span>".$val['id']."</span></p> 
                <div class='bottom'><p>微信扫码连wifi</p></div> 
            </div>
          </div>";
   }
    ?>

</div>
<script>


</script>
