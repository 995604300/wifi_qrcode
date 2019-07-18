<?php
/**
 * @package    http://www.rulaiyun.cn/
 * @author     wang <wangyaxu7019@dingtalk.com>
 * @copyright  Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\models;

/**
 * This is the model class for table "hj_user_allow".
 *
 * @property int $user_id    用户ID
 * @property int $to_user_id 指定用户ID
 * @property int $type       类型：1上级 2下级 3允许查看
 */
class UserAllow extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hj_user_allow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {

    }
}
