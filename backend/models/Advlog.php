<?php
/**
 * @package    http://www.rulaiyun.cn/
 * @author     wang <wangyaxu7019@dingtalk.com>
 * @copyright  Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "log".
 *
 * @property string $username
 * @property string $ip
 * @property string $data
 * @property string $created_at
 */
class Advlog extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%adv_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adv_id', 'type'], 'integer'],
            [['nick_name', 'created_at'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adv_id' => 'id',
            'type' => '广告类型',
            'nick_name' => '昵称',
            'created_at' => '观看时间',
        ];
    }

    public function getImage()
    {
        return $this->hasOne(Image::className(),['id' => 'adv_id']);
    }

    public function getVideo()
    {
        return $this->hasOne(Video::className(),['id' => 'adv_id']);
    }

    public function getWifi()
    {
        return $this->hasOne(Wifi::className(),['id' => 'wifi_id']);
    }
}
