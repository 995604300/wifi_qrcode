<?php

use yii\helpers\Html;
use \kartik\dynagrid\DynaGrid;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \backend\models\VideoSearch */
/* @var $context \backend\controllers\VideoController */

$this->title = '视频广告浏览记录';
$this->params['breadcrumbs'][] = ['label' => '视频广告列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $adv_id, 'url' => ['view', 'id' => $adv_id]];
$this->params['breadcrumbs'][] = $this-> title;
?>

<div class="wrapper wrapper-content" style="margin-top: 40px">

    <?php $gridColumns = [
        [
            'class' => 'backend\components\grid\SerialColumn'
        ],
        [
            'attribute'=>'title',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute'=>'nick_name',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'created_at',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
            'width' => '220px',
        ],

    ]; ?>
    <table class="table table-bordered">
        <tr>
            <th>序号</th>
            <th>昵称</th>
            <th>省</th>
            <th>市</th>
            <th>县区</th>
            <th>场所</th>
            <th>扫描二维码id</th>
            <th>观看时间</th>
        </tr>
        <?php foreach ($data as $key=>$val): ?>
            <tr>
                <td>
                    <?= $key+1;?>
                </td>
                <td>
                    <?= empty($val->nick_name) ? '未获取到昵称' : $val->nick_name;?>
                </td>
                <td>
                    <?= \backend\models\Area::getName($val->wifi->province);?>
                </td>
                <td>
                    <?= \backend\models\Area::getName($val->wifi->city);?>
                </td>
                <td>
                    <?= \backend\models\Area::getName($val->wifi->area);?>
                </td>
                <td>
                    <?= $val->wifi->name;?>
                </td>
                <td>
                    <?=  $val->qrcode_id;?>
                </td>
                <td>
                    <?=$val->created_at?>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>

    <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>

    </div>
</div>
<script>

</script>