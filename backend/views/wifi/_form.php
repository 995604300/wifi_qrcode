<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use backend\models\Area;


/* @var $this yii\web\View */
/* @var $model backend\models\Dictionary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wifi-form" xmlns="http://www.w3.org/1999/html">

    <?php  $form = ActiveForm::begin(); ?>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <label style="font-size: larger">必填项</label>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'describtion')->textInput(['maxlength' => true]) ?>
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
                <div class="col-lg-4 col-md-4">
                    <?= $form->field($model, 'province')->widget(Select2::classname(), [
                        'data' => \backend\models\Area::getSubcat(),
                        'options' => ['placeholder' => '请选择'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?= $form->field($model, 'city')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' =>[$model->city => Area::getName($model->city)],
                        'options' => ['placeholder' => '请选择'],
                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                            'depends'=>['wifi-province'],
                            'url' => Url::to(['/wifi/get-subcat']),
                            'loadingText' => '正在加载',
                        ]
                    ]);?>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?= $form->field($model, 'area')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' =>[$model->area => Area::getName($model->area)],
                        'options' => ['placeholder' => '请选择'],
                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                            'depends'=>['wifi-city'],
                            'url' => Url::to(['/wifi/get-subcat']),
                            'loadingText' => '正在加载',
                        ]
                    ]);?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'SSID')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <?= $form->field($model, 'industry')->widget(Select2::classname(), [
                        'data' => \backend\models\Industry::getIndustry(),
                        'options' => ['placeholder' => '选择行业'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?= $form->field($model, 'sign')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


