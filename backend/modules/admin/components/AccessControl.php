<?php

namespace mdm\admin\components;

use yii\web\ForbiddenHttpException;
use yii\base\Module;
use Yii;
use yii\web\User;
use yii\di\Instance;

/**
 * 访问控制过滤器（Access Control Filter，ACF）是一种简单的授权方法，最适用于只需要一些简单访问控制的应用程序。
 * 正如其名称所示，ACF是一个动作过滤器，可以作为行为附加到控制器或模块。
 * ACF将检查一组访问规则，以确保当前用户可以访问请求的操作。
 *
 * 要使用AccessControl，请在应用程序配置中将其声明为行为。
 * 例如.
 *
 * ```
 * 'as access' => [
 *     'class' => 'mdm\admin\components\AccessControl',
 *     'allowActions' => ['site/login', 'site/error']
 * ]
 * ```
 *
 * @property User $user
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since  1.0
 */
class AccessControl extends \yii\base\ActionFilter
{
    /**
     * @var User 用户检查访问。
     */
    private $_user = 'user';
    /**
     * @var array 不需要检查访问的动作列表。
     */
    public $allowActions = [];

    /**
     * 获取用户
     *
     * @return User
     */
    public function getUser()
    {
        if (!$this->_user instanceof User) {
            $this->_user = Instance::ensure($this->_user, User::className());
        }
        return $this->_user;
    }

    /**
     * 设置用户
     *
     * @param User|string $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $actionId = $action->getUniqueId();
        $user = $this->getUser();
        if (Helper::checkRoute('/'.$actionId, Yii::$app->getRequest()->get(), $user)) {
            return true;
        }
        $this->denyAccess($user);
    }

    /**
     * 拒绝用户的访问。
     * 如果他是一个guest，默认的实现将把用户重定向到登录页面;
     * 如果用户已经登录，则会抛出403 HTTP异常。
     *
     * @param  User $user 当前用户
     * @throws ForbiddenHttpException 如果用户已经登录。
     */
    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * @inheritdoc
     */
    protected function isActive($action)
    {
        $uniqueId = $action->getUniqueId();
        if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
            return false;
        }

        $user = $this->getUser();
        if ($user->getIsGuest()) {
            $loginUrl = null;
            if (is_array($user->loginUrl) && isset($user->loginUrl[0])) {
                $loginUrl = $user->loginUrl[0];
            } elseif (is_string($user->loginUrl)) {
                $loginUrl = $user->loginUrl;
            }
            if (!is_null($loginUrl) && trim($loginUrl, '/') === $uniqueId) {
                return false;
            }
        }

        if ($this->owner instanceof Module) {
            // convert action uniqueId into an ID relative to the module
            $mid = $this->owner->getUniqueId();
            $id = $uniqueId;
            if ($mid !== '' && strpos($id, $mid.'/') === 0) {
                $id = substr($id, strlen($mid) + 1);
            }
        } else {
            $id = $action->id;
        }

        foreach ($this->allowActions as $route) {
            if (substr($route, -1) === '*') {
                $route = rtrim($route, "*");
                if ($route === '' || strpos($id, $route) === 0) {
                    return false;
                }
            } else {
                if ($id === $route) {
                    return false;
                }
            }
        }

        if ($action->controller->hasMethod('allowAction') && in_array($action->id, $action->controller->allowAction())) {
            return false;
        }

        return true;
    }
}
