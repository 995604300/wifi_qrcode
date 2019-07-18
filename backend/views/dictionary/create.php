<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dictionary */

$this->title = '创建字典';
$this->params['breadcrumbs'][] = ['label' => '字典列表', 'url' => ['index','type'=>Yii::$app->request->get('type')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="dictionary-create">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
