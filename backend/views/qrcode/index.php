<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use kartik\popover\PopoverX;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$this->title = '二维码列表';
$this->params['breadcrumbs'][] = $this-> title;
?>



<div class="wrapper wrapper-content" style="margin-top: 40px">
    <input type="hidden" id="massage" value="<?=$massage?>">
    <?php //$this->render('_search', ['model' => $searchModel]);  ?>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="btn-group pull-right" style="margin-bottom: 10px;" role="group">
                <?php PopoverX::begin([
                                    'placement' => PopoverX::ALIGN_BOTTOM,
                                    'toggleButton' => ['label'=>'生成二维码', 'class'=>'btn btn-primary'],
                                    'header' => '<i class="fa fa-qrcode"></i> 生成二维码',
                                    'footer' => Html::Button('生成', [
                                            'class' => 'btn btn-sm btn-primary',
                                            'onclick' => '$("#create").trigger("submit")',
                                        ]) . Html::button('清空', [
                                            'class' => 'btn btn-sm btn-default',
                                            'onclick' => '$("#create").trigger("reset")'
                                        ])
                                ]);
                // form with an id used for action buttons in footer
                $form = ActiveForm::begin(['fieldConfig'=>['showLabels'=>false], 'options' => ['id'=>'create'],'action' => ['create']]);
                echo $form->field($model, 'times')->textInput(['placeholder'=>'生成数量']);
                echo $form->field($model, 'user')->widget(\kartik\select2\Select2::classname(), [
                        'data' => \backend\models\User::getUser(),
                        'options' => ['placeholder' => '分配用户'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ActiveForm::end();
                PopoverX::end();
                ?>
                <?=  Html::Button('展示二维码', [
                    'class' => 'btn btn-success',
                    'id' => 'show',
                    'data-type' => 'addTag',
                ]) ?>
            </div>
        </div>
    </div>

    <?php $gridColumns = [
        [
            'class' => 'backend\components\grid\SerialColumn'
        ],
        [
            'class' => 'kartik\grid\CheckboxColumn',
            'headerOptions' => ['class' => 'kartik-sheet-style'],
        ],
        [
            'attribute'=>'id',
            'label'=>'id',
            'value'=>'id',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute'=>'wifi_name',
            'label'=>'场所名称',
            'value'=>'wifi.name',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute'=>'wifi_describtion',
            'label'=>'场所说明',
            'value'=>'wifi.describtion',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],
        [
            'attribute' => 'create_time',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
            'width' => '220px',
            'filter' => \kartik\daterange\DateRangePicker::widget([    // 日期组件
                                                                       'model' => $searchModel,
                                                                       'language' => Yii::$app->language,
                                                                       'attribute' => 'create_time',
                                                                  ]),
        ],
        [
            'attribute' => 'update_time',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
            'width' => '220px',
            'filter' => \kartik\daterange\DateRangePicker::widget([    // 日期组件
                                                                       'model' => $searchModel,
                                                                       'language' => Yii::$app->language,
                                                                       'attribute' => 'update_time',
                                                                  ]),
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => '操作',
            'template' => '{view}{delete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', '查看'),
                        'aria-label' => Yii::t('yii', '查看'),
                        'data-pjax' => '0',
                        'style' => 'margin:0 10px'
                    ];
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options) ;
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', '删除'),
                        'aria-label' => Yii::t('yii', '删除'),
                        'data-confirm' => Yii::t('yii', '您确定要删除吗？'),
                        'data-pjax' => '0',
                        'style' => 'margin:0 10px'
                    ];
                    $urlType = $url;
                    return Html::a('<span class="glyphicon glyphicon-trash text-danger"></span>', $urlType, $options ) ;
                },

            ],
            'headerOptions' => ['width' => '100'],
        ],

    ]; ?>

    <div class="ibox float-e-margins" style="margin-top: 10px">
        <div class="ibox-title" style="position: relative;">
            <h5 style="float: left;"> <?=$this->title?></h5>
        </div>
        <div class="ibox-content">
            <?= GridView::widget([
                                     'id' => 'kv-grid-qrcode',
                                     'dataProvider' => $dataProvider,
                                     'filterModel' => $searchModel,
                                     'columns' => $gridColumns,
                                     'containerOptions' => ['style' => 'overflow: auto'],
                                     'resizableColumns' => true,
                                     'bordered' => true,
                                     'striped' => false,
                                     'condensed' => false,
                                     'responsive' => true,
                                     'hover' => true,
                                     //  'showPageSummary' => true,
                                     'filterSelector' => "select[name='" . $dataProvider->getPagination()->pageSizeParam . "'],input[name='" . $dataProvider->getPagination()->pageParam . "']",
                                     'pager' => [
                                         'class' => \common\widgets\LinkPager::className(),
                                     ],

                                 ]); ?>
        </div>
        <div id="form" style="display: none">
            <div style="margin: 20px">
                <label style="margin: 10px"><input name="model" type="radio" value="1" checked /><img src="/img/model1.png" width="80px"></label>
                <label style="margin: 10px"><input name="model" type="radio" value="2" /><img src="/img/model2.png" width="80px"> </label>
                <label style="margin: 10px"><input name="model" type="radio" value="3" /><img src="/img/model3.png" width="80px"> </label>
                <br>
                <span style="margin-left: 35px">406x306</span>
                <span style="margin-left: 63px">252x200</span>
                <span style="margin-left: 63px">270x330</span>
            </div>
        </div>
    </div>
</div>
<script src="/js/crypto-js.js"></script>

<script>
    $(function () {
        var key_base = "rulaiyun"; // 加密秘钥的基值
        var iv_base = "2X3GCw78PsgKB5Ap"; // 加密所需iv基值
        var get=function(a){
            var key_hash=CryptoJS.MD5(key_base);
            var key=CryptoJS.enc.Utf8.parse(key_hash);
            var iv=CryptoJS.enc.Utf8.parse(iv_base);
            var res=CryptoJS.AES.encrypt(a,key,{iv:iv,mode:CryptoJS.mode.CBC,padding:CryptoJS.pad.ZeroPadding});
            return res.toString()
        };

        $('#show').click(function () {
            var keys = $('#kv-grid-qrcode').yiiGridView('getSelectedRows');
            if (keys.length == 0) {
                layer.msg('请选择二维码后尝试', {icon: 2});
            }else {
                var keys = get(keys.join(','));
                layer.open({
                    title: '选择模板',
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    area: ['500px', '300px'], //宽高
                    btn: ['确定'], //宽高
                    content: $('#form'),
                    yes: function () {
                        var model = $('input[name="model"]:checked').val();
                        layer.closeAll();
                        window.open('show?keys=' + encodeURIComponent(keys) + '&model=' + model);
                    },
                    end: function () {
                        $('#form').hide();
                    }
                });

            }
        })
    })

</script>