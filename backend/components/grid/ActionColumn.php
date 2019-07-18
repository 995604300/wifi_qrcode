<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\components\grid;

/**
 * 重写grid 操作 列
 * Class ActionCloumn
 *
 * @package backend\components\grid
 * @author  wang
 */
class ActionColumn extends \kartik\grid\ActionColumn
{
    /**
     * @var string
     */
    public $header = '操作';

    /**
     * @var string
     */
    public $template = '{view} &nbsp;&nbsp;{update}&nbsp;&nbsp; {delete}';

    /**
     * @var array
     */
    public $contentOptions = [
        'width' => '90',
    ];

    public $width = '';
}
