<?php
/**
 * @package    http://www.rulaiyun.cn/
 * @author     wang <wangyaxu7019@dingtalk.com>
 * @copyright  Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\models;

/**
 * This is the model class for table "log".
 *
 * @property string $username
 * @property string $ip
 * @property string $data
 * @property string $created_at
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'create_time'], 'string', 'max' => 32],
            [['ip', 'data'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'ip' => 'Ip',
            'data' => 'Data',
            'created_at' => 'Create Time',
        ];
    }
}
