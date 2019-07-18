<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use backend\models\Area;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form" xmlns="http://www.w3.org/1999/html">

    <?php $form = ActiveForm::begin(); ?>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
             <label style="font-size: larger">必填项</label>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?php if ($model->id): ?>
                        <?= $form->field($model, 'password_new')->textInput(['placeholder' => '不填默认为原始密码'])->label('密码') ?>
                        <?= $form->field($model, 'auth_key')->hiddenInput()->label(false) ?>
                    <?php else: ?>
                        <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?= $form->field($model, 'status')->label('状态')
                             ->widget(\kartik\switchinput\SwitchInput::classname(), [
                                 'type' => \kartik\switchinput\SwitchInput::CHECKBOX,
                                 'pluginOptions' => [
                                     'onText' => '启用',
                                     'offText' => '停用',
                                     'onColor' => 'success',
                                     'offColor' => 'danger',
                                 ],
                             ]); ?>
                </div>
            </div>

        </div>
    </div>


    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <label style="font-size: larger">选填项</label>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'nick_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <?php if(empty(Yii::$app->user->identity->province)){
                        echo $form->field($model, 'province')->widget(Select2::classname(), [
                            'data' => Area::getSubcat(),
                            'options' => ['placeholder' => '请选择'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    }
                    else {
                        echo $form->field($model, 'province')->widget(Select2::classname(), [
                            'data' => [Yii::$app->user->identity->province => Area::getName(Yii::$app->user->identity->province)],
                        ]);
                    }
                    ?>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?php if(empty(Yii::$app->user->identity->city)){
                        echo $form->field($model, 'city')->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
                            'data' =>[$model->city => Area::getName($model->city)],
                            'options' => ['placeholder' => '请选择'],
                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                            'pluginOptions'=>[
                                'depends'=>['user-province'],
                                'url' => Url::to(['/wifi/get-subcat']),
                                'loadingText' => '正在加载',
                            ]
                        ]);
                        $initDepends = 'user-province';
                    }
                    else {
                        echo $form->field($model, 'city')->widget(Select2::classname(), [
                            'data' => [Yii::$app->user->identity->city => Area::getName(Yii::$app->user->identity->city)],
                        ]);
                        $initDepends = 'user-city';
                    }
                    ?>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?php if(empty(Yii::$app->user->identity->area)){
                        echo $form->field($model, 'area')->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
                            'data' =>[$model->area => Area::getName($model->area)],
                            'options' => ['placeholder' => '请选择'],
                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                            'pluginOptions'=>[
                                'initialize' => true,
                                'initDepends' => [$initDepends],
                                'depends'=>['user-city'],
                                'url' => Url::to(['/wifi/get-subcat']),
                                'loadingText' => '正在加载',
                            ]
                        ]);
                    }
                    else {
                        echo $form->field($model, 'area')->widget(Select2::classname(), [
                            'data' => [Yii::$app->user->identity->area => Area::getName(Yii::$app->user->identity->area)],
                        ]);
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

    <div class="text-center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


