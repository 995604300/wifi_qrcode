<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Image */

$this->title = '创建图片广告';
$this->params['breadcrumbs'][] = ['label' => '图片广告列表', 'url' => ['index','type'=>Yii::$app->request->get('type')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="dictionary-create">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>