<?php
/**
 * @package    http://www.rulaiyun.cn/
 * @author     wang <wangyaxu7019@dingtalk.com>
 * @copyright  Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hj_dictionary".
 *
 * @property int    $id
 * @property string $name       名称
 * @property string $type       类型
 * @property string $value      内容
 * @property string $code       唯一标识
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Dictionary extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dictionary}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['value'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'type'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 50],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'value' => 'Value',
            'code' => 'Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * 根据类型返回
     *
     * @param $type
     * @return array|string
     * @author wang
     */
    public static function getDictionaryValue($type)
    {
        $cache = Yii::$app->cache;
        $data = $cache->get('dict_type'.$type);
        if ($data === false) {
            $model = self::find()->where('type=:type', [':type' => $type])->asArray()->one();
            $valueArr = explode('|', $model['value']);
            $data = [];
            foreach ($valueArr as $key => $v) {
                $data[$v] = $v;
            }
            $cache->set('dict_'.$type, $data, 60 * 60);
        }

        return $data;
    }

    /**
     * 获取制表字段
     *
     * @return array|mixed
     */
    public static function getBudgetFields()
    {
        $cache = Yii::$app->cache;
        $data = $cache->get('dict_budget_fields1');
        if ($data === false) {

            $model = self::find()->where('type=:type', [':type' => 'budget'])->asArray()->one();
            $data = explode("\n", $model['value']);
            foreach ($data as $key => $val) {
                $data[$key] = explode('|', $val);
            }

            $cache->set('dict_budget_fields', $data, 60 * 60);
        }

        return $data;

    }

    public static function getTaxRate()
    {
        $cache = Yii::$app->cache;
        $data = $cache->get('dict_tax_rate33');
        if ($data === false) {

            $model = self::find()->where('type=:type', [':type' => 'tax_rate'])->asArray()->one();
            $_data = explode("\n", $model['value']);
            $data = [];
            foreach ($_data as $key => $val) {
                $_val = explode("|", $val);
                $data[$_val[0]] = $_val;
            }
            $cache->set('dict_tax_rate2', $data, 60 * 60);

        }

        return $data;
    }

    /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        if (!$insert) {
            Yii::$app->cache->delete('dict_'.$this->type);
        }
    }

    /**
     *
     */
    public function afterDelete()
    {
        parent::afterDelete(); // TODO: Change the autogenerated stub
        Yii::$app->cache->delete('dict_'.$this->type);
    }

}
