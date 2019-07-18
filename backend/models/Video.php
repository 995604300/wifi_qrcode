<?php
/**
 * @package    http://www.rulaiyun.cn/
 * @author     wang <wangyaxu7019@dingtalk.com>
 * @copyright  Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\models;

use app\models\FileUpload;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "rly_video_adv".
 *
 * @property int    $id
 * @property string $title                 标题
 * @property string $times                 展示次数
 * @property string $video_path            文件路径
 * @property string $description           描述
 * @property string $order                 排序
 * @property string $province              省
 * @property string $city                  市
 * @property string $area                  县
 * @property string $industry              行业
 * @property string $status                审核状态
 * @property string $create_time           创建时间
 * @property string $update_time           更新时间
 */
class Video extends FileUpload
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%video_adv}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'title',
                    'times',
                ],
                'required',
            ],
            [
                [
                    'times',
                    'province',
                    'city',
                    'industry',
                    'area',
                    'order',
                    'status',
                ],
                'integer',
            ],
            [
                [
                    'order',
                    'description',
                    'video_path',
                ],
                'safe'
            ]

//            [
//                ['mobile'],
//                'match',
//                'pattern' => '/^1[34578]\d{9}$/',
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '创建者id',
            'title' => '广告名称',
            'video_path' => '视频路径',
            'times' => '展示次数',
            'order' => '排序',
            'province' => '省',
            'city' => '市',
            'area' => '县区',
            'industry' => '行业',
            'status' => '审核状态',
            'description' => '描述',
            'create_time' => '创建日期',
            'update_time' => '更新日期',
        ];
    }

    public function getWifi(){
        return $this->hasMany(Wifi::className(),['id'=>'wifi_id'])
                    ->viaTable('rly_wifi_advertisement',['adv_id'=>'id'],function ($query){
                        $query->onCondition(['type' => 2]);
                    });
    }


    /**
     * @param bool $insert
     * @return bool
     * @author wang
     */
    public function beforeSave($insert)
    {

        if (!empty($this->uploadFile)) {
            $this->video_path = $this->upload();
        }
        if ($insert) {    //新增
            $this->user_id = \Yii::$app->user->identity->getId();
            $this->create_time = date('Y-m-d H:i:s');
            $this->update_time = date('Y-m-d H:i:s');
        } else {    //修改
            $this->status = 0;
            $this->update_time = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @param bool  $insert
     * @param array $changedAttributes
     * @author wang
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * 删除之后
     */
    public function afterDelete()
    {
        parent::afterDelete(); // TODO: Change the autogenerated stub
    }


}
