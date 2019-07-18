<?php

use backend\components\treegrid\TreeGrid;
use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\RouteRule;
use mdm\admin\components\Configs;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('rbac-admin', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);

//print_r($dataProvider);exit;
?>

<div class="wrapper wrapper-content" style="margin-top: 40px">
    <input type="hidden" id="massage" value="<?=$massage?>">
    <?php //$this->render('_search', ['model' => $searchModel]);  ?>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="btn-group pull-right" style="margin-bottom: 10px;" role="group">
                <?= Html::a(Yii::t('rbac-admin', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <div class="ibox float-e-margins" style="margin-top: 10px">
        <div class="ibox-title" style="position: relative;">
            <h5 style="float: left;"> <?=$this->title?></h5>
        </div>
        <div class="ibox-content">
            <?php
            echo  TreeGrid::widget([
                'dataProvider' => $dataProvider,
                'keyColumnName' => 'id',//主键id
                'parentColumnName' => 'parentid',//父类字段
                'columns' => [
                    [
                        'attribute' => 'name',
                        'label' => Yii::t('rbac-admin', 'Name'),
                    ],
                    [
                        'attribute' => 'ruleName',
                        'label' => Yii::t('rbac-admin', 'Rule Name'),
                        'headerOptions' => ['width' => '150'],
                    ],
                    [
                        'attribute' => 'description',
                        'label' => Yii::t('rbac-admin', 'Description'),
                    ],
                    [
                        'attribute' => 'order',
                        'label' => Yii::t('rbac-admin', 'Order'),
                        'headerOptions' => ['width' => '50'],
                    ],
                    [
                        'class'     => 'backend\components\grid\ActionColumn',
                        'header' => '操作',
                        'headerOptions' => ['width' => '100'],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $options = [
                                    'title' => Yii::t('yii', '查看'),
                                ];
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',Url::toRoute(["permission/view",'id'=>$model->name]), $options) ;
                            },
                            'update' => function ($url, $model, $key) {
                                $options = [
                                    'title' => Yii::t('yii', '更新'),
                                ];
                                return Html::a('<span class="glyphicon glyphicon-pencil text-warning"></span>', Url::toRoute(["permission/update",'id'=>$model->name]), $options) ;
                            },
                            'delete' => function ($url, $model, $key) {
                                $options = [
                                    'title' => Yii::t('yii', '删除'),
                                    'aria-label' => Yii::t('yii', '删除'),
                                    'data-confirm' => Yii::t('yii', '您确定要删除吗？'),
                                ];
                                return Html::a('<span class="glyphicon glyphicon-trash text-danger"></span>', Url::toRoute(["permission/delete",'id'=>$model->name]), $options ) ;
                            },
                        ],

                    ],
                ]
            ]); ?>
        </div>

    </div>
</div>
<script>
$(function(){
    var massage = $('#massage').val();
    if(massage) {
        layer.alert(massage);
    }
});
</script>