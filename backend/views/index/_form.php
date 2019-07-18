<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <?php if ($type == 1): ?>
            <div class="col-lg-6">
                <?= $form->field($model, 'superior')->widget(Select2::classname(), [
                    'data' => $userIgnoreSelf,
                    'options' => ['prompt' => '请选择'],
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>
            </div>
            <div class="col-lg-6" style="color: red;">* &nbsp;上级：预算审核报表提交审核的领导或审核人</div>
        <?php endif; ?>
        <?php if ($type == 2): ?>
            <div style="padding: 0px 20px;">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'seats')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'worker')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'business')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <? $model->allow_view = explode(',', $model->allow_view) ?>
                        <?= $form->field($model, 'allow_view')->widget(Select2::classname(), [
                            'data' => $userIgnoreSelf,
                            'options' => [
                                'prompt' => '请选择',
                                'multiple' => true
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == 3): ?>
            <div class="col-lg-6">
                <? $model->junior = explode(',', $model->junior) ?>
                <?= $form->field($model, 'junior')->widget(Select2::classname(), [
                    'data' => $userIgnoreSelf,
                    'options' => [
                        'prompt' => '请选择',
                        'multiple' => true
                    ],
                ]); ?>
            </div>
            <div class="col-lg-6" style="color: red;">* &nbsp;下级：将预算审核报表提交由你审核的部门负责人或项目负责人</div>
        <?php endif; ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>