<?php

use mdm\admin\AnimateAsset;
use mdm\admin\components\Configs;
use mdm\admin\components\Item;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AnimateAsset::register($this);
YiiAsset::register($this);
$manager = Configs::authManager();
$items = $model->getItems();
$assigneds = array_keys($items['assigned']);
foreach (\yii\helpers\ArrayHelper::toArray($manager->getPermissions()) as $value) {
    if($value['name'][0] != '/') {
        if(in_array($value['name'],$assigneds)){
            $value['checked'] = true;
        } else {
            $value['checked'] = false;
        }
        $available[] = $value;
    }
}
//print_r($available);
$opts = Json::htmlEncode([
    'items' => $items,
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>

    <div class="wrapper wrapper-content">
        <div class="ibox float-e-margins" style="margin-top: 10px">
            <div class="ibox-title" style="position: relative;">
                <h5 style="float: left;"> <?=$this->title?></h5>
            </div>
            <div class="ibox-content text-center">
                <?= \liyuze\ztree\ZTree::widget([
                    'id' => 'category_tree',	//自定义id
                    'setting' => '{
                        data: {
                            simpleData: {
                                enable: true,
                                pIdKey:"parentid"
                            }
                        },
                        view: {
                             dblClickExpand: true,
                             showLine: true,
                             selectMulti:true,
                             showIcon: false  
                        },
                        check:{
                            enable:true 
                        },
                        callback:{
                            onCheck: zTreeOnCheck
                        }  
                    }',
                    'nodes' => json_encode($available,JSON_UNESCAPED_UNICODE)
                ]);

                ?>
                <div style="display: none" id="items"></div>
                <?php
                echo Html::submitButton( Yii::t('rbac-admin', '保 存') , [
                    'class' =>  'btn btn-primary btn-save',
                    'name' => 'submit-button'
                ])
                ?>
            </div>
        </div>
    </div>

<?php $this->beginBlock('js_block'); ?>
    <script>
        $(function() {
            var treeObj = $.fn.zTree.getZTreeObj("category_tree");
            treeObj.expandAll(true);
        }) ;
        function zTreeOnCheck(event, treeId, treeNode) {
            var treeObj = $.fn.zTree.getZTreeObj("category_tree");
            var nodes = treeObj.getCheckedNodes();
            $(".item").remove();
            if( nodes.length > 0){
                $.each(nodes,function(i,val) {
                    var name = nodes[i].name;
                    $('#items').append("<input class='item' name='items[]' value='"+name+"'>");
                    // console.log(name)
                });
            }
        }

        $('.btn-save').on('click',function () {
            var that = $(this);
            var item = $(".item");
            var name = [];

            that.attr("disabled", true);
            $(".item").each(function() {
                name.push(this.value)
            });
            $.ajax({
                url:"<?=Url::toRoute(['/admin/role/save','id'=>$model->name])?>",
                data:{'items[]':name},
                type:'POST',
                dataType:'json',
                success:function (res) {
                    if(res.code == 1){
                        layer.msg(res.message, {icon: 1});
                    }else{
                        layer.msg(res.message, {icon: 2});
                    }
                    that.attr("disabled", false);
                },
                error:function (error) {

                }
            });

        })

    </script>

<?php $this->endBlock(); ?>