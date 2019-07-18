<?php
/**
 * @package    http://www.rulaiyun.cn/
 * @author     wang <wangyaxu7019@dingtalk.com>
 * @copyright  Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rly_user".
 *
 * @property int    $id
 * @property string $username             帐号
 * @property string $nick_name            昵称
 * @property string $area                 所属地区
 * @property string $auth_key             密钥
 * @property string $password_hash        密码
 * @property string $password_reset_token 密码重置TOKEN
 * @property string $mobile               手机号
 * @property string $user_money           余额
 * @property string $freeze_money         冻结资金
 * @property string $kpi_money            kpi资金
 * @property string $total_income         累计收益
 * @property int    $status               用户状态
 * @property string $create_time          创建时间
 * @property string $update_time          更新时间
 */
class User extends \common\models\User
{
    const  USER_ACTIVE = 1;    //开启
    const  USER_INACTIVE = 0;    //冻结

    public $password_new;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'username'
                ],
                'required',
            ],
            [
                [
                    'username',
                ],
                'unique',
            ],
            [
                [
                    'status',
                    'province',
                    'city',
                    'area',
                ],
                'integer',
            ],
            [
                [
                    'username',
                    'auth_key',
                ],
                'string',
                'max' => 32,
            ],
            [
                [
                    'password_hash',
                    'password_reset_token',
                ],
                'string',
                'max' => 255,
            ],
            [
                ['mobile'],
                'match',
                'pattern' => '/^1[34578]\d{9}$/',
            ],
            [
                [
                    'auth_key',
                    'password_new'
                ],
                'safe'
            ]
        ];

    }

    /**获取昵称
     *
     * @param $user_id
     * @return string
     */
    public static function getUserNickName($user_id)
    {
        $user = self::findOne($user_id);
        return $user->nick_name;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '登陆账号',
            'nick_name' => '微信昵称',
            'auth_key' => '密钥',
            'password_hash' => '密码',
            'password_reset_token' => '密码重置令牌',
            'mobile' => '手机号码',
            'user_money' => '余额',
            'freeze_money' => '冻结资金',
            'kpi_money' => 'kpi金额',
            'total_income' => '累计收益',
            'status' => '状态',
            'province' => '省',
            'city' => '市',
            'area' => '县',
            'create_time' => '创建日期',
            'update_time' => '更新日期',
        ];
    }

    public function childrenIdArray($parent_id){
        $res = $this->find()->select('id')->where(['parent_id'=>$parent_id])->asArray()->all();
        $res = array_column($res,'id');
        $res[] = $parent_id;
        return $res;
    }

    /**
     * 获取后台可登录用户列表
     * @param $id
     * @return string
     * author: Wang YX
     */
    public function getUser(){
        $res = self::find()->select('id,username')->where(['not',['username'=>NULL]])->asArray()->all();
        $data = ArrayHelper::map($res,'id','username');
        return $data;
    }

    public function getUsergrouplist()
    {
        /**
         * 第一个参数为要关联的字表模型类名称，
         *第二个参数指定 通过子表的 customer_id 去关联主表的 id 字段
         */
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public function getUsergroup()
    {
        /**
         * 第一个参数为要关联的字表模型类名称，
         *第二个参数指定 通过子表的 customer_id 去关联主表的 id 字段
         */
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @param bool $insert
     * @return bool
     * @author wang
     */
    public function beforeSave($insert)
    {
        if ($insert) {    //新增

            /*密码*/
            if ($this->auth_key) {
                $this->setPassword($this->auth_key);
                $this->generateAuthKey();
            }

        } else {    //修改
            if ($this->password_new) {
                $this->setPassword($this->password_new);
                $this->generateAuthKey();
            }

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
