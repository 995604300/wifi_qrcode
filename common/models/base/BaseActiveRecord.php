<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * 重写数据基类
 * Class BaseActiveRecord
 *
 * @package common\models\base
 * @author  wang wangyaxu7019@dingtalk.com
 */
class BaseActiveRecord extends ActiveRecord
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
}