<?php

use backend\components\treegrid\TreeGrid;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('rbac-admin', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content" style="margin-top: 40px">
    <?php $this->render('_search', ['model' => $searchModel]);  ?>
    <div class="ibox float-e-margins" >
        <div class="ibox-title">
            <div class="btn-group pull-right"  role="group">
                <?= Html::a(Yii::t('rbac-admin', 'Create Menu'), ['create'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <div class="ibox float-e-margins" style="margin-top: 10px">
        <div class="ibox-title" style="position: relative;">
            <h5 style="float: left;"> <?=$this->title?></h5>
        </div>
        <div class="ibox-content" id="menuTab">
            <?php
            echo  TreeGrid::widget([
                'dataProvider' => $dataProvider,
                'keyColumnName' => 'id',//主键ID
                'parentColumnName' => 'parent',//主键ID父类字段
                'pluginOptions' => [
                    //'initialState' => 'collapsed', //是否合并
                ],
                'columns' => [
                    'name',
                    'route',
                    [
                        'class'     => 'yii\grid\DataColumn',
                        'attribute' => 'order',
                        'contentOptions' => [
                            'width'=>'90'
                        ],
                    ],
                    [
                        'class'     => 'backend\components\grid\ActionColumn'
                    ]
                ]
            ]); ?>
        </div>

    </div>
</div>
