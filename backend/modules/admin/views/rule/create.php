<?php

use yii\helpers\Html;

/* @var $this  yii\web\View */
/* @var $model mdm\admin\models\BizRule */

$this->title = Yii::t('rbac-admin', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="auth-item-create">
        <div class="ibox float-e-margins" style="margin-top: 10px">
            <div class="ibox-title" style="position: relative;">
                <h5 style="float: left;"> <?=$this->title?></h5>
            </div>
            <div class="ibox-content">
                <?=
                $this->render('_form', [
                    'model' => $model,
                ]);
                ?></div>
        </div>
    </div>
</div>
