<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DictionarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wrapper wrapper-content">
    <div class="dictionary-search">

        <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get',]); ?>

        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'type') ?>

        <?= $form->field($model, 'value') ?>

        <?= $form->field($model, 'code') ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
