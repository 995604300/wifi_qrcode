<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dictionary */


$this->params['breadcrumbs'][] = ['label' => '字典列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="wrapper wrapper-content">
    <div class="dictionary-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
