<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <p class="text-right">
        <?= Html::a(Yii::t('rbac-admin', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('rbac-admin', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <div class="ibox float-e-margins">
        <div class="ibox-title" style="position: relative;">
            <h3 style="float: left"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="ibox-content">
            <?=
            DetailView::widget([
                                   'model' => $model,
                                   'attributes' => [
                                       'menuParent.name:text:Parent',
                                       'name',
                                       'route',
                                       'order',
                                   ],
                               ])
            ?>
        </div>
    </div>

</div>
