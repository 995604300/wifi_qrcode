<?php

namespace mdm\admin\components;

use Yii;
use yii\caching\Cache;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\rbac\ManagerInterface;

/**
 * 配置
 * 用于配置一些值。 要设置配置，你可以使用 [[\yii\base\Application::$params]]
 *
 * ```
 * return [
 *
 *     'mdm.admin.configs' => [
 *         'db' => 'customDb',
 *         'menuTable' => '{{%admin_menu}}',
 *         'cache' => [
 *             'class' => 'yii\caching\DbCache',
 *             'db' => ['dsn' => 'sqlite:@runtime/admin-cache.db'],
 *         ],
 *     ]
 * ];
 * ```
 *
 * or use [[\Yii::$container]]
 *
 * ```
 * Yii::$container->set('mdm\admin\components\Configs',[
 *     'db' => 'customDb',
 *     'menuTable' => 'admin_menu',
 * ]);
 * ```
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since  1.0
 */
class Configs extends \yii\base\Object
{
    const CACHE_TAG = 'mdm.admin';

    /**
     * @var ManagerInterface .
     */
    public $authManager = 'authManager';

    /**
     * @var 连接数据库连接。
     */
    public $db = 'db';

    /**
     * @var Connection Database connection.
     */
    public $userDb = 'db';

    /**
     * @var Cache 缓存组件。
     */
    public $cache = 'cache';

    /**
     * @var integer 缓存时间。 默认为一个小时。
     */
    public $cacheDuration = 3600;

    /**
     * @var string 菜单表名称。
     */
    public $menuTable = '{{%menu}}';

    /**
     * @var string 菜单表名称。
     */
    public $userTable = '{{%user}}';

    /**
     * @var integer 用户注册的默认状态。  1 意思是活跃的。
     */
    public $defaultUserStatus = 1;

    /**
     * @var boolean 如果为true，那么AccessControl只检查路由是否被注册。
     */
    public $onlyRegisteredRoute = false;

    /**
     * @var boolean 如果为false，则AccessControl将检查没有规则。
     */
    public $strict = true;

    /**
     * @var array
     */
    public $options;

    /**
     * @var array|false
     */
    public $advanced;

    /**
     * @var self Instance of self
     */
    private static $_instance;

    private static $_classes = [
        'db' => 'yii\db\Connection',
        'userDb' => 'yii\db\Connection',
        'cache' => 'yii\caching\Cache',
        'authManager' => 'yii\rbac\ManagerInterface',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        foreach (self::$_classes as $key => $class) {
            try {
                $this->{$key} = empty($this->{$key}) ? null : Instance::ensure($this->{$key}, $class);
            } catch (\Exception $exc) {
                $this->{$key} = null;
                Yii::error($exc->getMessage());
            }
        }
    }

    /**
     * 创建单例
     * Create instance of self
     *
     * @return static
     */
    public static function instance()
    {
        if (self::$_instance === null) {
            $type = ArrayHelper::getValue(Yii::$app->params, 'mdm.admin.configs', []);
            if (is_array($type) && !isset($type['class'])) {
                $type['class'] = static::className();
            }

            return self::$_instance = Yii::createObject($type);
        }

        return self::$_instance;
    }

    public static function __callStatic($name, $arguments)
    {
        $instance = static::instance();
        if ($instance->hasProperty($name)) {
            return $instance->$name;
        } else {
            if (count($arguments)) {
                $instance->options[$name] = reset($arguments);
            } else {
                return array_key_exists($name, $instance->options) ? $instance->options[$name] : null;
            }
        }
    }

    /**
     * @return Connection
     */
    public static function db()
    {
        return static::instance()->db;
    }

    /**
     * @return Connection
     */
    public static function userDb()
    {
        return static::instance()->userDb;
    }

    /**
     * @return Cache
     */
    public static function cache()
    {
        return static::instance()->cache;
    }

    /**
     * @return ManagerInterface
     */
    public static function authManager()
    {
        return static::instance()->authManager;
    }

    /**
     * @return integer
     */
    public static function cacheDuration()
    {
        return static::instance()->cacheDuration;
    }

    /**
     * @return string
     */
    public static function menuTable()
    {
        return static::instance()->menuTable;
    }

    /**
     * @return string
     */
    public static function userTable()
    {
        return static::instance()->userTable;
    }

    /**
     * @return string
     */
    public static function defaultUserStatus()
    {
        return static::instance()->defaultUserStatus;
    }

    /**
     * @return boolean
     */
    public static function onlyRegisteredRoute()
    {
        return static::instance()->onlyRegisteredRoute;
    }

    /**
     * @return boolean
     */
    public static function strict()
    {
        return static::instance()->strict;
    }
}
