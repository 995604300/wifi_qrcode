<?php

use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\models\Menu;
use yii\helpers\Json;
use mdm\admin\AutocompleteAsset;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
    'menus' => Menu::getMenuSource(),
    'routes' => Menu::getSavedRoutes(),
]);
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));
?>

<div class="ibox float-e-margins" style="margin-top: 10px">
    <div class="ibox-title" style="position: relative;">
        <h5 style="float: left;"> <?=$this->title?></h5>
    </div>
    <div class="ibox-content">
        <?php $form = ActiveForm::begin(); ?>
        <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

                <?php
                $map = \mdm\admin\models\Menu::find()->select('*,parent as parentid')->indexBy('id')->orderBy('order')->asArray()->all();
                /* 当更新菜单时 去除自身及子集系列 */
                if($model->id){
                    foreach ($map as $key => $val) {
                        if ($val['id'] == $model->id) {
                            unset($map[$key]);
                        }
                    }
                }
                $treeSelect = new \backend\components\helpers\Tree();
                $treeSelect->init(ArrayHelper::index($map,'id'));
                echo $form->field($model, 'parent')->dropDownList( $treeSelect->getTreeSelect(0),['prompt' => '选择父级','encode'=>false]);
                ?>
                <?= $form->field($model, 'route')->textInput(['id' => 'route']) ?>
                <?= $form->field($model, 'status')->label('状态')
                    ->widget(SwitchInput::classname(), [
                        'type' => SwitchInput::CHECKBOX,
                        'pluginOptions' => [
                            'onText' => '启用',
                            'offText' => '停用',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                        ],
                    ]); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'order')->input('number') ?>
                <?= $form->field($model, 'icon')->label('图标') ?>
                <?= $form->field($model, 'data')->textarea(['rows' => 5]) ?>
            </div>
        </div>

        <div class="form-group text-center" style="margin-top: 20px">
            <?=
            Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), ['class' => $model->isNewRecord
                ? 'btn btn-primary' : 'btn btn-primary'])
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

