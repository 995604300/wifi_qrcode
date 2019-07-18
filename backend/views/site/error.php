<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<script>
    layer.open({
        type: 1
        ,area: ['350px', 'auto']
       // ,offset: 't'
        ,id: 'layerMsg'
        ,content: '<div style="padding: 20px 20px"><?= nl2br(Html::encode($message)) ?></div>'
        ,btn: '关闭'
        ,btnAlign: 'c' //按钮居中
        ,shade: 0 //不显示遮罩
        ,btn: ['关闭']
        ,yes: function(){
            layer.closeAll()
           // parent.appCloseActive();//关闭当前窗口
        }
        ,btn2: function(index, layero){
            //history.go(-1);
        }
    });
</script>
