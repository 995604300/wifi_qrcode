<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dictionary */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dictionaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="dictionary-view">

        <p>
            <?= Html::a('更新', ['update', 'id' => $model->id,'type' =>$model->type], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('删除', ['delete', 'id' => $model->id,'type' =>$model->type], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '您确定要删除吗?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'code',
            ],
        ]) ?>

    </div>
</div>
