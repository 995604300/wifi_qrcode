<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auth Item Children';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Auth Item Child', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'parent',
            'child',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view}{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', '回复'),
                            'aria-label' => Yii::t('yii', '回复'),
                            'data-pjax' => '0',
                            'style' => 'margin:0 20px'
                        ];
                        return Html::a('<span class="glyphicon glyphicon-envelope"></span>', $url, $options) ;
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', '删除'),
                            'aria-label' => Yii::t('yii', '删除'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options ) ;
                    },
                ],
                'headerOptions' => ['width' => '100'],
            ],
        ],
    ]); ?>
</div>
