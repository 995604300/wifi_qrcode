<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var mdm\admin\models\AuthItem $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <p class="text-right">
        <?= Html::a(Yii::t('rbac-admin', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?php
        echo Html::a(Yii::t('rbac-admin', 'Delete'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data-confirm' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
            'data-method' => 'post',
        ]);
        ?>
    </p>
    <div class="ibox float-e-margins">
        <div class="ibox-title" style="position: relative;">
            <h3 style="float: left"><?= Html::encode($this->title) ?></h3>

        </div>
        <div class="ibox-content">
            <?php
            echo DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            'name',
                                            'className',
                                        ],
                                    ]);
            ?>
        </div>
    </div>







</div>
