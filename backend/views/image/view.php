<?php


use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \backend\models\Image */
/* @var $context \backend\controllers\ImageController */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '图片广告列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除这个广告吗?',
            ],
        ]) ?>
        <?= Html::a('查看观看记录', ['advlog', 'id' => $model->id], ['class' => 'btn btn-success',]) ?>
    </p>

    <?= DetailView::widget([
                               'model' => $model,
                               'attributes' => [
                                   'id',
                                   'title',
                                   'times',
                                   'order',
                                   ['attribute'=>'province',
                                    'value'=>function($model){
                                        return \backend\models\Area::getName($model->province);
                                    }
                                   ],
                                   ['attribute'=>'city',
                                    'value'=>function($model){
                                        return \backend\models\Area::getName($model->city);
                                    }
                                   ],
                                   ['attribute'=>'area',
                                    'value'=>function($model){
                                        return \backend\models\Area::getName($model->area);
                                    }
                                   ],
                                   ['attribute'=>'industry',
                                    'value'=>function($model){
                                        return \backend\models\Industry::getName($model->industry);
                                    }
                                   ],
                                   ['attribute'=>'status',
                                    'value'=>function($model){
                                       switch ($model->status){
                                           case 0:
                                               return '未审核';
                                           case 1:
                                               return '已通过';
                                           case 2:
                                               return '未通过';
                                       }
                                    }
                                   ],
                                   'description:ntext',
                                   ['attribute'=>'video_path',
                                    'label'=>'图片',
                                    'format'=>'raw',
                                    'value'=>function($model){
                                        return Html::img($model->image_path,['width'=>'400px']);
                                    }
                                   ],
                                   'create_time',
                                   'update_time',
                               ],
                           ]) ?>


    <div class="text-center col-lg-12 col-md-12">
        <?php
        $user_id = \Yii::$app->user->identity->getId();
        $res = \Yii::$app->authManager->getRolesByUser($user_id);
        if (!empty($res['超级管理员'])){
            echo Html::a('通过', ['check', 'id' => $model->id, 'status'=>1], ['class' => 'btn btn-success','style'=>'margin-right:60px']);
            echo Html::a('未通过', ['check', 'id' => $model->id, 'status'=>2], ['class' => 'btn btn-danger','style'=>'margin-left:60px']);
        }
        ?>

    </div>
</div>
