<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2
 * Time: 15:51
 */
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>


<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <div class="form-inline">
                <div class="form-group" style="width: 200px">
                    <?php $form = ActiveForm::begin(); ?>
                    <?php echo Select2::widget([
                                                   'id' => 'budgetNo',
                                                   'name' => 'budgetNo',
                                                   'data' => $budgetOn,
                                                   'value' => $budgetNo,
                                                   'options' => [
                                                       'multiple' => false,
                                                       'placeholder' => '选择预算期数',
                                                   ],
                                               ]);
                    ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="ibox-content">
            <div class="inputfile">

                <?php echo FileInput::widget([
                                                 'name' => 'fileUpload',
                                                 'id' => 'fileUpload',
                                                 'language' => 'zh',
                                                 'options' => [
                                                     'multiple' => false,
                                                     'enctype' => 'multipart/form-data',
                                                 ],
                                                 'pluginOptions' => [
                                                     'previewFileType' => 'text',
                                                     'uploadClass'=>'btn btn-danger',
                                                     'dropZoneTitle' => '请上传附件<br>只支持单个上传，否则将会覆盖',
                                                     'uploadUrl' => Url::to(['/annex/file-upload']),
                                                     'deleteUrl' => url::to(['/annex/file-delete']),
                                                     'maxFileSize' => 3000,
                                                     'maxFileCount' => '1',
                                                     'msgSelected' => '本月已上传',
                                                     'allowedPreviewTypes' => ['image'],
                                                     'initialPreview' => $pathinfo,
                                                     'textEncoding' => 'utf-8',
                                                     'removeFromPreviewOnError' => true,
                                                     'showRemove' => false, //显示移除按钮
                                                     'allowedFileExtensions' => ['xls', 'xlsx'],
                                                     'uploadExtraData' => ['budgetNo' => $budgetNo],
                                                     'deleteExtraData' => ['budgetNo' => $budgetNo],
                                                     'layoutTemplates' => [
                                                         'actionZoom' => '',
                                                         'actionUpload' => '',
                                                     ],
                                                     'autoReplace' => true,
                                                 ],
                                             ]);
                ?>
            </div>
        </div>

    </div>
</div>
<?php

$css = <<<CSS
 .file-caption-main{
    margin-top: 5px;
 }
CSS;
$this->registerCss($css);
$this->registerCssFile("@web/css/jquery-confirm.min.css");
$this->registerJsFile("@web/js/jquery-confirm.min.js");

?>

<script>

    /*  上传时鉴定是否选择制表期数 */
    $("#fileUpload").click(function ()
    {
        var budgetNo = $('#budgetNo').find("option:selected").val();
        if (budgetNo == '')
        {
            var index = layer.msg('请选择制表期数!', {icon: 5});
            layer.style(index, {
                'top': '0'
            });
            return false;
        }
        return true;
    });

    /* 执行获取月份跳转 */
    $('#budgetNo').change(function () {
        var budgetNo = $(this).find("option:selected").val();
        var url = "<?=Url::toRoute(['annex/index'])?>";
        location.replace(url + '?budgetNo=' + budgetNo);
    });


    /* 上传成功回调 */
    $("#fileUpload").on("fileuploaded", function (event, data, previewId, index) {
        if (data.response.code == 200) {
            var urls = "<?= Url::toRoute(['annex/index'])?>" + "?budgetNo=" + "<?= $budgetNo?>";
            window.location.href = urls;
            var index = layer.msg('上传成功!', {icon: 1});
            layer.style(index, {'top': '0'});
        }
    });

    /*上传失败回调 */
    $('#fileUpload').on('fileerror', function (event, data, msg) {
        var index = layer.msg('上传失败!', {icon: 5});
        layer.style(index, {'top': '0'});
    });

    /* 上传成功后删除提示*/
    $('#fileUpload').on('filebeforedelete', function ()
    {
        return new Promise(function (resolve, reject) {
            $.confirm({
                title: '删除提醒!',
                content: '您确定要删除吗?',
                type: 'red',
                buttons: {
                    '确定': {
                        btnClass: 'btn-primary text-white',
                        keys: ['enter'],
                        action: function () {
                            resolve();
                        }
                    },
                    '取消': function () {
                    }
                }
            });
        });
    }).on('filedeleted', function () {
        var index = layer.msg('删除成功!', {icon: 1});
        layer.style(index, {'top': '0'});
    });

    /* 验证不通过，上传按钮不可点 */
    $('#fileUpload').on('fileuploaderror', function (event, data, msg)
    {
        var form = data.form,
            files = data.files,
            extra = data.extra,
            response = data.response,
            reader = data.reader;
        $('.fileinput-upload').attr('disabled', true);
        $('#fileUpload').attr('disabled', true);
        $('#fileUpload').removeAttr('href');
        // $(".kv-zoom-cache").css('display','block');

    });


    $('#fileUpload').on('fileclear', function (event)
    {
        var url = "<?=Url::toRoute(['annex/index'])?>";
        location.replace(url + '?budgetNo=' + "<?= $budgetNo?>");
    });

</script>