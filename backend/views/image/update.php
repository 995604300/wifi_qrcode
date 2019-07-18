<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Image */

$this->title = '更新图片广告信息 ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '图片广告列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->title]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="wrapper wrapper-content ">
    <div class="ibox-content">
        <div class="row pd-10">
            <h1><?= Html::encode($this->title) ?></h1>
            <hr>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>

    </div>
</div>