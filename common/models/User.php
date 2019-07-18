<?php
/**
 * @package   common\models
 * @author    wang <wangyaxu7019@dingtalk.com>
 * @version   1.0.0
 */

namespace common\models;

use backend\models\AuthAssignment;
use backend\models\UserAllow;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * 用户表模型
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
class User extends ActiveRecord implements IdentityInterface
{
    //用户状态
    const STATUS_DELETED = 0;//禁止
    const STATUS_ACTIVE = 1;//可用


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
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Implemented for Oauth2 Interface
     *
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

        return null;
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public function checkUserCredentials($username, $password)
    {
        $user = static::findByUsername($username);
        if (empty($user)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public function getUserDetails($username)
    {
        $user = static::findByUsername($username);
        return ['user_id' => $user->getId()];
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                                   'password_reset_token' => $token,
                                   'status' => self::STATUS_ACTIVE,
                               ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
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
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * 用户角色关联
     *
     * @return \yii\db\ActiveQuery
     * @author    wang
     */
    public function getRoles()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id'])->asArray();
    }

    /**
     *
     * 获取当前用户角色 返回格式 [ 0 => '管理员', 1 => '测试']
     *
     * @return \yii\db\ActiveQuery
     * @author    wang
     */
    public function getUserRoles()
    {
        $roles = Yii::$app->user->identity->roles;
        return array_column($roles, 'item_name');
    }


}
