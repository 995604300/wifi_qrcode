<?php
return [
    'components' => [
        //数据库配置
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=182.254.161.72;dbname=wifi',
            'username' => 'wifi',
            'password' => 'degattg..',
            'charset' => 'utf8',
            'tablePrefix' => 'rly_',
        ],
        //邮件服务器配置
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php'
                    ],
                ],
            ],
        ],
        /*'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
        ],*/
    ],
];
