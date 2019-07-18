<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\components\grid;

use Yii;

/**
 * 重写GridView
 * Class GridView
 *
 * @package backend\components\grid
 * @author  wang
 */
class GridView extends \kartik\grid\GridView
{
    /**
     * @var array the HTML attributes for the grid table element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $tableOptions = [
        'class' => 'table table-striped table-bordered table-hover'
    ];

    public $krajeeDialogSettings = [
        'overrideYiiConfirm' => false //取消kartik删除弹出框
    ];

    /**
     * @var string
     */
    public $layout = <<<HTML
<div class = "clearfix" ></div>
    {items}
      <div class="row" style="margin-top: 10px;margin-left: 5px">
        <div class="pull-left">
            <div >
            {summary}
            </div>
        </div>
        <div class="pull-right" >
            {pager}
        </div>
    </div>
HTML;

    /**
     * 重写删除提示
     * Registers client assets for the [[GridView]] widget.
     *
     * @author wang
     */
    protected function registerAssets()
    {
        parent::registerAssets();
        $view = $this->getView();
        $krajeeYiiConfirm = <<<JS
        yii.confirm = function (message, ok, cancel) {
            layer.confirm(message, {icon: 3, title:'提示'}, function(result) {
               if (result) {
                    !ok || ok();
                } else {
                    !cancel || cancel();
                }
                layer.close(index);
            });
        };
JS;
        $view->registerJs($krajeeYiiConfirm);
    }

}