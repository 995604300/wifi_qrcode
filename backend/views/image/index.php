<?php

use yii\helpers\Html;
use backend\components\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \backend\models\ImageSearch */
/* @var $context \backend\controllers\ImageController */

$this->title = '图片广告列表';
$this->params['breadcrumbs'][] = $this-> title;
?>

<div class="wrapper wrapper-content" style="margin-top: 40px">
    <input type="hidden" id="massage" value="<?=$massage?>">
    <?php //$this->render('_search', ['model' => $searchModel]);  ?>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="btn-group pull-right" style="margin-bottom: 10px;" role="group">
                <?= Html::a(Yii::t('rbac-admin', '创建图片广告 ' . $labels['Image']), ['create'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php $gridColumns = [
        [
            'class' => 'backend\components\grid\SerialColumn'
        ],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('plus', ['model' => $model->wifi]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true,
        ],
        [
            'attribute'=>'title',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute'=>'times',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute'=>'order',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute'=>'description',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'province',
            'value' => function($model, $key, $index, $column){
                return \backend\models\Area::getName($model->province);
            },
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'city',
            'value' => function($model, $key, $index, $column){
                return \backend\models\Area::getName($model->city);
            },
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'area',
            'value' => function($model, $key, $index, $column){
                return \backend\models\Area::getName($model->area);
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
        ['attribute'=>'status',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'value'=>function($model){
                switch ($model->status){
                    case 0:
                        return '未审核';
                    case 1:
                        return '已通过';
                    case 2:
                        return '未通过';
                }
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => [0=>'未审核', 1=>'已通过', 2=>'未通过'],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => '全部'],
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