<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'name'=>'wifi连接系统',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request'=>[
            //'baseUrl'=>'/backend',
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        //URL管理
        "urlManager" => [
            //用于表明urlManager是否启用URL美化功能，在Yii1.1中称为path格式URL，
            // Yii2.0中改称美化。
            // 默认不启用。但实际使用中，特别是产品环境，一般都会启用。
            "enablePrettyUrl" => true,
            // 是否启用严格解析，如启用严格解析，要求当前请求应至少匹配1个路由规则，
            // 否则认为是无效路由。
            // 这个选项仅在 enablePrettyUrl 启用后才有效。
            "enableStrictParsing" => false,
            // 是否在URL中显示入口脚本。是对美化功能的进一步补充。
            "showScriptName" => false,
            // 指定续接在URL后面的一个后缀，如 .html 之类的。仅在 enablePrettyUrl 启用时有效。
            "suffix" => "",
            "rules" => [
                "<controller:\w+>/<id:\d+>"=>"<controller>/view",
                "<controller:\w+>/<action:\w+>"=>"<controller>/<action>"
            ],
        ],
        'authManager' => [
            'class' => 'mdm\admin\components\DbManager', // 使用数据库管理配置文件
            "defaultRoles" => ["guest"],
        ],

        //禁用加载自带的 jquery 和 bootstrap.css 文件
        'assetManager'=>[
            'bundles'=>[
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => []
                ],
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => []
                ],
            ],

        ],
    ],
    //定义模块
    "modules" => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // your other grid module settings
        ],
        "admin" => [
            "class" => 'mdm\admin\Module',
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ],
    ],
    //定义别名
    "aliases" => [
        "@mdm/admin" => "@backend/modules/admin",
    ],
    'as access' => [
        //ACF肯定要加,加了才会自动验证是否有权限
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            //允许访问的action
            //controller/action
            //'*'
            'site/*',
            'index/*'
        ]
    ],

    'params' => $params,


];
