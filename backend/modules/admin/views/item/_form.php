<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\components\RouteRule;
use mdm\admin\AutocompleteAsset;
use yii\helpers\Json;
use mdm\admin\components\Configs;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use mdm\admin\models\searchs\AuthItem as AuthItemSearch;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$rules = Configs::authManager()->getRules();
unset($rules[RouteRule::RULE_NAME]);
$source = Json::htmlEncode(array_keys($rules));

$js = <<<JS
    $('#rule_name').autocomplete({
        source: $source,
    });
JS;
AutocompleteAsset::register($this);
$this->registerJs($js);

/* 处理下拉树状结构为数组 */
$select = ArrayHelper::toArray($allmodel);

/* 当更新权限时 去除自身及子集系列 */
if($model->getItem()->id){
    foreach ($select as $key => $val) {
        if ($val['id'] == $model->getItem()->id) {
            unset($select[$key]);
        }
    }
}
?>


<?php $form = ActiveForm::begin(); ?>
<?= Html::activeHiddenInput($model, 'parentid', ['id' => 'parent_id']); ?>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

        <?php
        /* 加载树状下拉框 */
        $treeSelect = new \backend\components\helpers\Tree();
        $treeSelect->init(ArrayHelper::index(array_values($select),'id'));
        echo $form->field($model, 'parentid')->dropDownList( $treeSelect->getTreeSelect(0),['prompt' => '选择父级','encode'=>false]);
        ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
        <?= $form->field($model, 'order')->input('number') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'ruleName')->textInput(['id' => 'rule_name']) ?>

        <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>
    </div>
</div>

<div class="form-group text-center">
    <?php
    echo Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), [
        'class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary',
        'name' => 'submit-button'])
    ?>
</div>

<?php ActiveForm::end(); ?>
