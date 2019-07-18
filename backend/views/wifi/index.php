<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use backend\models\Area;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$this->title = 'WIFI列表';
$this->params['breadcrumbs'][] = $this-> title;

?>

<div class="wrapper wrapper-content" style="margin-top: 40px">
    <input type="hidden" id="massage" value="<?=$massage?>">
    <?php //$this->render('_search', ['model' => $searchModel]);  ?>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="btn-group pull-right" style="margin-bottom: 10px;" role="group">
                <?= Html::a(Yii::t('rbac-admin', '创建wifi ' . $labels['Wifi']), ['create'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php $gridColumns = [
    [
        'class' => 'backend\components\grid\SerialColumn'
    ],
    [
        'attribute'=>'name',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute'=>'describtion',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute'=>'province',
        'value' => function ($model, $key, $index, $widget) {
            return Area::getName($model->province);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute'=>'city',
        'value' => function ($model, $key, $index, $widget) {
            return Area::getName($model->city);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute'=>'area',
        'value' => function ($model, $key, $index, $widget) {
            return Area::getName($model->area);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute' => 'industry',
        'value' => function($model, $key, $index, $column){
            return \backend\models\Industry::getName($model->industry);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute'=>'address',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute'=>'SSID',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute'=>'sign',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute' => 'create_time',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
        'width' => '220px',
        'filter' => \kartik\daterange\DateRangePicker::widget([    // 日期组件
                                                                   'model' => $searchModel,
                                                                   'language' => Yii::$app->language,
                                                                   'attribute' => 'create_time',
                                                              ]),
    ],
    [
        'attribute' => 'update_time',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
        'width' => '220px',
        'filter' => \kartik\daterange\DateRangePicker::widget([    // 日期组件
                                                                   'model' => $searchModel,
                                                                   'language' => Yii::$app->language,
                                                                   'attribute' => 'update_time',
                                                              ]),
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => '操作',
        'template' => '{view}{update}{delete}',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('yii', '查看'),
                    'aria-label' => Yii::t('yii', '查看'),
                    'data-pjax' => '0',
                    'style' => 'margin:0 10px'
                ];
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options) ;
            },
            'update' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('yii', '更新'),
                    'aria-label' => Yii::t('yii', '更新'),
                    'data-pjax' => '0',
                    'style' => 'margin:0 20px'
                ];
                $urlType = $url;
                return Html::a('<span class="glyphicon glyphicon-pencil text-warning"></span>', $urlType, $options) ;
            },
            'delete' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('yii', '删除'),
                    'aria-label' => Yii::t('yii', '删除'),
                    'data-confirm' => Yii::t('yii', '您确定要删除吗？'),
                    'data-pjax' => '0',
                    'style' => 'margin:0 10px'
                ];
                $urlType = $url;
                return Html::a('<span class="glyphicon glyphicon-trash text-danger"></span>', $urlType, $options ) ;
            },

        ],
        'headerOptions' => ['width' => '100'],
    ],

]; ?>

    <div class="ibox float-e-margins" style="margin-top: 10px">
        <div class="ibox-title" style="position: relative;">
            <h5 style="float: left;"> <?=$this->title?></h5>
        </div>
        <div class="ibox-content">
            <?= GridView::widget([
                                     'id' => 'kv-grid-user',
                                     'dataProvider' => $dataProvider,
                                     'filterModel' => $searchModel,
                                     'columns' => $gridColumns,
                                     'containerOptions' => ['style' => 'overflow: auto'],
                                     'resizableColumns' => true,
                                     'bordered' => true,
                                     'striped' => false,
                                     'condensed' => false,
                                     'responsive' => true,
                                     'hover' => true,
                                     //  'showPageSummary' => true,
                                     'filterSelector' => "select[name='" . $dataProvider->getPagination()->pageSizeParam . "'],input[name='" . $dataProvider->getPagination()->pageParam . "']",
                                     'pager' => [
                                         'class' => \common\widgets\LinkPager::className(),
                                     ],

                                 ]); ?>
        </div>

    </div>
</div>
<script>

</script>