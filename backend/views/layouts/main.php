<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ? Html::encode($this->title) : Yii::$app->name; ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->
    <link rel="shortcut icon" href="favicon.ico">
    <?= Html::cssFile('@web/layui/css/layui.css') ?>
    <?= Html::cssFile('@web/css/bootstrap.min.css') ?>
    <?= Html::cssFile('@web/css/font-awesome.min.css') ?>
    <?= Html::cssFile('@web/css/animate.min.css') ?>
    <?= Html::cssFile('@web/css/style.min.css') ?>
    <?= Html::cssFile('@web/css/site.css') ?>
    <?= Html::jsFile('@web/js/jquery.min.js') ?>
    <?= Html::jsFile('@web/js/jquery.cookie.js') ?>
    <?= Html::jsFile('@web/js/bootstrap.min.js') ?>
    <?= Html::jsFile('@web/js/main.js') ?>
    <?= Html::jsFile('@web/layui/layui.all.js'); ?>
    <?php $this->head() ?>
    <style>
        .radius {
            font-size: 20px;
            color: #797979;
        }
    </style>
</head>
<body class="fixed-sidebar full-height-layout gray-bg">
<?php $this->beginBody() ?>
<?php if ((Yii::$app->controller->module->defaultRoute != "site") || (Yii::$app->controller->module->defaultRoute == "site" && Yii::$app->controller->module->requestedRoute != "" && Yii::$app->controller->module->requestedRoute != "site/login" && Yii::$app->controller->module->requestedRoute != "index/update")): ?>
    <nav class="breadcrumb fix_top navbar-fixed-top" style="height: 45px;">
        <div class="pull-left" style="margin: 15px 10px">
            <?php
                echo Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => '首页',
                        'url' => \yii\helpers\Url::toRoute('index/welcome')
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : ''
                ])
            ?>
        </div>
        <div class="pull-right" style="text-align: right;padding: 7px 20px 0 0;">
            <a class="radius go-back" style="line-height:1.6em;margin-top:3px" title="后退">
                <span class="fa fa-reply"></span>
            </a>
            &nbsp;
            <a class="radius" style="line-height:1.6em;margin-top:3px"
               href="javascript:location.replace(location.href);" title="刷新">
                <span class="fa fa-refresh"></span>
            </a>
            &nbsp;
        </div>
    </nav>
<?php endif; ?>

<?= $content ?>
<?php $this->endBody() ?>

<?php

    if (Yii::$app->getSession()->hasFlash('success')) {
        $s_msg = Yii::$app->session->getFlash('success');
        echo "<script> 
                var index = layer.msg('" . $s_msg . "', {icon: 1}); 
                   layer.style(index, {
                    'top':'0'
                });
          ;</script>";

    }
    if (Yii::$app->getSession()->hasFlash('error')) {
        $e_msg = Yii::$app->session->getFlash('error');
        echo "<script> 
                var index = layer.msg('" . $e_msg . "', {icon: 5}); 
                   layer.style(index, {
                   'top':'0'
                });
          ;</script>";

    };
    if (Yii::$app->getSession()->hasFlash('info')) {
        $s_msg = Yii::$app->session->getFlash('info');
        echo "<script> 
                var index = layer.msg('" . $s_msg . "', {icon: 1}); 
                   layer.style(index, {
                    'top':'0'
                });
             parent.location.reload(); 
          ;</script>";
    }

?>

<?php if (isset($this->blocks['js_block'])): ?>
    <?= $this->blocks['js_block'] ?>
<?php else: ?>

<?php endif; ?>

</body>
</html>
<?php
    $js = <<<JS
    $('.go-back').on('click', function() {
        if(document.referrer === '/backend/web/'){
            return;
        }else{
            window.history.go(-1);
        }
    })
JS;
    $this->registerJs($js);
?>
<?php $this->endPage() ?>


