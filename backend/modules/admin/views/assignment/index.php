<?php
use backend\components\grid\GridView;
use common\widgets\LinkPager;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'backend\components\grid\SerialColumn'],
    $usernameField
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
    'class' => 'backend\components\grid\ActionColumn',
    'template' => '{view}'
];
?>
<div class="wrapper wrapper-content">
    <div class="ibox float-e-margins" style="margin-top: 10px">
        <div class="ibox-title" style="position: relative;">
            <h5 style="float: left;"> <?=$this->title?></h5>
        </div>
        <div class="ibox-content">
            <?php Pjax::begin(); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $columns,
                'filterSelector' => "select[name='" . $dataProvider->getPagination()->pageSizeParam . "'],input[name='" . $dataProvider->getPagination()->pageParam . "']",
                'pager' => [
                    'class' => LinkPager::className()
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
