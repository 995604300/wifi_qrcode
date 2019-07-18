<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = '创建帐号';
$this->params['breadcrumbs'][] = ['label' => '帐号管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
?>
<div class="wrapper wrapper-content">
    <div class="user-update">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>

