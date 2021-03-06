<?php
/**
 * @package    http://www.rulaiyun.cn/
 * @author     wang <wangyaxu7019@dingtalk.com>
 * @copyright  Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rly_industry".
 *
 * @property int    $id
 * @property string $name
 * @property string $parent_id
 * @property string $level
 */
class Industry extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%industry}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                ],
                'required',
            ],

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
            'name' => '名称',
        ];
    }

    /**
     * 根据id获取省市县名称
     * @param $id
     * @return string
     * author: Wang YX
     */
    public function getName($id = 0){
        if ($id == 0){

        }else {
            $data = \Yii::$app->cache->getOrSet('industry'.$id, function () use ($id) {
                $res = self::findOne($id);
                return $res->name;
            });
        }

        return $data;
    }


    /**
     * 获取全部行业数据
     * @param $id
     * @return string
     * author: Wang YX
     */
    public function getIndustry(){
        $res = self::find()->select(['id', 'name'])->asArray()->all();
        $data = ArrayHelper::map($res,'id','name');
        return $data;
    }

    /**
     * 根据名称模糊查询出id
     * @param $name
     * author: Wang YX
     */
    public function searchName($name){
        $res = self::find()->andWhere(['like' , 'name' , $name])->asArray()->all();
        return $res;
    }

    /**
     * @param bool $insert
     * @return bool
     * @author wang
     */
    public function beforeSave($insert)
    {

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
