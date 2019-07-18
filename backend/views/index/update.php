<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

?>
<div class="wrapper wrapper-content current-form">
    <div class="user-update">
        <?= $this->render('_form', [
            'model' => $model,
            'userIgnoreSelf'=>$userIgnoreSelf,
            'type' => $type
        ]) ?>

    </div>
</div>

<?php
    $css = <<<CSS
    .current-form{
        margin-top: 0px; 
    }
CSS;
    $this->registerCss($css);
?>