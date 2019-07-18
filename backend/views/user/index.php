<?php
use common\widgets\LinkPager;
use backend\components\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '帐号管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="ibox float-e-margins" style="margin-top: 10px">
        <div class="ibox-title text-right">
            <?= Html::a('创建帐号', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php $gridColumns = [
        [
            'class' => 'backend\components\grid\SerialColumn'
        ],
        [
            'attribute' => 'username',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'nick_name',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'mobile',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'user_money',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
            'width' => '110px'
        ],
        [
            'attribute' => 'freeze_money',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'kpi_money',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'total_income',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'status',
            'hAlign' => 'center',
            'value' => function ($model) {
                return $model->status == 1 ? "<span style='color:#23c6c8;'><strong>启用</strong></span>" : "<span style='color: #ed5565;;'><strong>冻结</strong></strong></span>";
            },
            'format' => 'raw',
            'filter' => [
                1 => '启用',
                0 => '冻结'
            ],
            'width' => '100px'

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
            'template' => '{update}{plus}{delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', '编辑'),
                        'aria-label' => Yii::t('yii', '编辑'),
                        'data-pjax' => '0',
                        'style' => 'margin:0 12px 0 8px'
                    ];
                    return Html::a('<span class="glyphicon glyphicon-pencil text-warning"></span>', $url, $options);
                },
                'plus' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', '分配权限'),
                        'aria-label' => Yii::t('yii', '分配权限'),
                        'data-pjax' => '0',
                        'style' => 'margin:0 12px 0 0'
                    ];
                    if ($model->username != 'admin' && $model->status == 1) {
                        return Html::a('<span class="glyphicon glyphicon-cog"></span>', [
                            '/admin/assignment/view',
                            'id' => $model->id
                        ], $options);
                    }
                },
                'delete' => function ($url, $model, $key) {
                    if ($model->status == 1) {
                        $title = "冻结";
                        $icon = "fa fa-unlock-alt fa-lg";
                    } else {
                        $title = "启用";
                        $icon = "fa fa-unlock fa-lg";
                    }
                    $options = [
                        'title' => Yii::t('yii', $title),
                        'aria-label' => Yii::t('yii', $title),
                        'data-confirm' => Yii::t('yii', "您确定要" . $title . "该用户吗？"),
                        'data-pjax' => '0',
                    ];
                    if ($model->username != 'admin') {
                        return Html::a("<span class='$icon text-danger'></span>", $url, $options);
                    }
                },

            ],
            'headerOptions' => ['width' => '100'],
        ],

    ];
    ?>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <label style="font-size: larger">帐号列表</label>
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
                    'class' => LinkPager::className(),
                ],

            ]); ?>
        </div>
    </div>

    <?php
        $js = <<<JS
$('.hoverData').popover({
    html : true 
});
JS;
        $this->registerJs($js);
    ?>
