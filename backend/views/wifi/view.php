<?php


use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除这个WIFI吗?',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
                               'model' => $model,
                               'attributes' => [
                                   'id',
                                   'name',
                                   'area',
                                   'describtion:ntext',
                                   'address',
                                   'SSID',
                                   'password',
                                   'sign',
                                   'connect_times',
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
                                   'create_time',
                                   'update_time',
                               ],
                           ]) ?>

</div>
