<?php

use liyunfang\pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DictionarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '字典列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="dictionary-index">

        <p>
            <?= Html::a('新建', ['create','type'=>$type], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'name',
                //'type',
               // 'value',
                'code',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '操作',
                    'template' => '{update}{delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            $options = [
                                'title' => Yii::t('yii', '更新'),
                                'aria-label' => Yii::t('yii', '更新'),
                                'data-pjax' => '0',
                                'style' => 'margin:0 20px'
                            ];
                            $urlType = $url.'&type='.$model->type;
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $urlType, $options) ;
                        },
                        'delete' => function ($url, $model, $key) {
                            $options = [
                                'title' => Yii::t('yii', '删除'),
                                'aria-label' => Yii::t('yii', '删除'),
                                'data-confirm' => Yii::t('yii', '您确定要删除吗？'),
                                'data-pjax' => '0',
                            ];
                            $urlType = $url.'&type='.$model->type;
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $urlType, $options ) ;
                        },
                    ],
                    'headerOptions' => ['width' => '100'],
                ],
            ],
            'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
            'pager' => [
                'class' => LinkPager::className(),
                'template' => '{pageButtons} {customPage} {pageSize}',
                'pageSizeList' => [10, 20, 30, 50],
                'pageSizeMargin' => 'margin-left:5px;margin-right:5px;',
                'pageSizeOptions' => ['class' => 'form-control','style' => 'display: inline-block;width:auto;margin-top:0px;'],
                'customPageWidth' => 50,
                'customPageBefore' => '跳转 ',
                'customPageAfter' => ' 页 ',
                'customPageMargin' => 'margin-left:5px;margin-right:5px;',
                'customPageOptions' => ['class' => 'form-control','style' => 'display: inline-block;margin-top:0px;']
            ],
        ]); ?>
    </div>
</div>
