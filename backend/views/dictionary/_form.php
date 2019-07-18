<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dictionary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wrapper wrapper-content">
    <div class="dictionary-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'type')->hiddenInput(['value' => Yii::$app->request->get('type')])->label("") ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
