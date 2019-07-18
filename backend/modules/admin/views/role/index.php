<?php

use backend\components\grid\GridView;
use common\widgets\LinkPager;
use yii\helpers\Html;
use mdm\admin\components\RouteRule;
use mdm\admin\components\Configs;

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
?>
<div class="wrapper wrapper-content" style="margin-top: 40px">
    <div class="ibox float-e-margins" >
        <div class="ibox-title text-right">
            <?= Html::a(Yii::t('rbac-admin', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <div class="ibox float-e-margins" style="margin-top: 10px">
        <div class="ibox-title" style="position: relative;">
            <h5 style="float: left;"> <?=$this->title?></h5>
        </div>
        <div class="ibox-content" id="roleTab">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'backend\components\grid\SerialColumn'],
                    [
                        'attribute' => 'name',
                        'label' => Yii::t('rbac-admin', 'Name'),
                        'width' =>'300px',
                        'hAlign' => 'center'
                    ],
                    [
                        'attribute' => 'ruleName',
                        'label' => Yii::t('rbac-admin', 'Rule Name'),
                        'filter' => $rules,
                        'width' =>'120px',
                        'hAlign' => 'center'
                    ],
                    [
                        'attribute' => 'description',
                        'label' => Yii::t('rbac-admin', 'Description'),
                        'hAlign' => 'center',
                    ],
                    [
                        'attribute' => 'order',
                        'label' => Yii::t('rbac-admin', 'Order'),
                        'width' =>'60px',
                        'hAlign' => 'center'
                    ],
                    [
                        'class' => 'backend\components\grid\ActionColumn',
                        'hAlign' => 'center',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $options = [
                                    'title' => '授权',
                                    'data-toggle="tooltip"',
                                ];
                                return Html::a('<span class="fa fa-key fa-lg"></span>', ['/admin/role/assign','id'=>$model->name], $options);
                            },
                        ]
                    ],
                ],
                'filterSelector' => "select[name='" . $dataProvider->getPagination()->pageSizeParam . "'],input[name='" . $dataProvider->getPagination()->pageParam . "']",
                'pager' => [
                    'class' => LinkPager::className()
                ],
            ])
            ?>

        </div>
    </div>
</div>
