<?php


use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '二维码详情', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
<!--        <?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>-->
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除这个二维码吗?',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
                               'model' => $model,
                               'attributes' => [
                                       'id',
                                       ['attribute'=>'wifi_name',
                                        'label'=>'场所名称',
                                        'value'=>$model->wifi->name,
                                       ],
                                       ['attribute'=>'wifi_describtion',
                                        'label'=>'场所说明',
                                        'value'=>$model->wifi->describtion,
                                       ],
                                       ['attribute'=>'wifi_area',
                                        'label'=>'wifi所属区域',
                                        'value'=>$model->wifi->area,
                                       ],
                                       ['attribute'=>'wifi_SSID',
                                        'label'=>'WIFI名称',
                                        'value'=>$model->wifi->SSID,
                                       ],
                                       ['attribute'=>'wifi_address',
                                        'label'=>'WIFI地址',
                                        'value'=>$model->wifi->address,
                                       ],
                                       ['attribute'=>'wifi_sign',
                                        'label'=>'wifi签名',
                                        'value'=>$model->wifi->sign,
                                       ],
                                       ['attribute'=>'show_times',
                                        'label'=>'被扫码次数',
                                        'value'=>$model->show_times,
                                       ],
                                       ['attribute'=>'qrcode_path',
                                        'label'=>'二维码',
                                        'format'=>'raw',
                                        'value'=>function($model){
                                            return Html::img($model->qrcode_path,['width'=>'120px']);
                                        }
                                       ],
                                       'create_time',
                                       'update_time',
                               ],
                           ]) ?>

</div>
