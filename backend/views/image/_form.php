<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;
use backend\models\Area;
use backend\models\Industry;

/* @var $this yii\web\View */
/* @var $model backend\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>


<?php  $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <label style="font-size: larger">必填项</label>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'times')->textInput(['maxlength' => true]) ?>
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
                    <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?= $form->field($model, 'industry')->widget(Select2::classname(), [
                        'data' => Industry::getIndustry(),
                        'options' => ['placeholder' => '选择行业'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <label class="control-label" for="video-uploadFile">图片文件</label>
                    <?= FileInput :: widget([
                            'model' => $model,
                            'attribute' => 'uploadFile',
                            'options' => ['multiple' => false],
                            'pluginOptions' => [
                                    'initialPreview' => [
                                            "$model->image_path"
                                    ],
                                    'initialPreviewAsData' => true ,
                                    'overwriteInitial' => false ,
                                    'maxFileSize' => 2800,
                                    'initialCaption' => "原图片",
                                    'initialPreviewConfig' => [
                                            [ 'caption' => '原图片'],
                                    ],

                            ],
                                            ])
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <label style="font-size: larger">选择地区分配广告</label>
        </div>
        <div class="ibox-content">
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
                                'depends'=>['image-province'],
                                'url' => Url::to(['/wifi/get-subcat']),
                                'loadingText' => '正在加载',
                            ]
                        ]);
                        $initDepends = 'image-province';
                    }
                    else {
                        echo $form->field($model, 'city')->widget(Select2::classname(), [
                            'data' => [Yii::$app->user->identity->city => Area::getName(Yii::$app->user->identity->city)],
                        ]);
                        $initDepends = 'image-city';
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
                                'depends'=>['image-city'],
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


