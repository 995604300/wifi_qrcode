<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\components\rbac;

use Yii;
use yii\rbac\Rule;

/**
 * 预算记录规则
 * Class BudgetSheetRule
 *
 * @package backend\components\rbac
 */
class BudgetSheetRule extends Rule
{
    public $name = 'BudgetSheetRule';

    public function execute($user, $item, $params)
    {
        // 这里先设置为false,逻辑上后面再完善
        return true;
    }
}