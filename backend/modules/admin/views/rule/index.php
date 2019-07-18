<?php
use common\widgets\LinkPager;
use yii\helpers\Html;


/* @var $this  yii\web\View */
/* @var $model mdm\admin\models\BizRule */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\BizRule */

$this->title = Yii::t('rbac-admin', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content" style="margin-top: 40px">
    <div class="role-index">
        <div class="ibox float-e-margins">
            <div class="ibox-title text-right">
                <?= Html::a(Yii::t('rbac-admin', 'Create Rule'), ['create'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <div class="ibox float-e-margins" style="margin-top: 10px">
            <div class="ibox-title" style="position: relative;">
                <h5 style="float: left;"> <?=$this->title?></h5>
            </div>
            <div class="ibox-content" id="ruleTab">
                <?=
                backend\components\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'backend\components\grid\SerialColumn',
                            'contentOptions' => [
                                'width'=>'60px'
                            ],
                        ],
                        [
                            'attribute' => 'name',
                            'label' => Yii::t('rbac-admin', 'Name'),
                        ],
                        [
                            'class' => 'backend\components\grid\ActionColumn'
                        ]
                    ],
                    'filterSelector' => "select[name='" . $dataProvider->getPagination()->pageSizeParam . "'],input[name='" . $dataProvider->getPagination()->pageParam . "']",
                    'pager' => [
                        'class' => LinkPager::className()
                    ],
                ]);
                ?>
            </div>

        </div>
    </div>
</div>
