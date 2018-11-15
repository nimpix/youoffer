<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@xml' => '/var/www/offer.com/data/www/youoffer.com/uploads/xml',
//        '@xml' => $_SERVER['ROOT'] . '/uploads/xml',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['admin', 'product','manager','guest']
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=offer_com_db',
            'username' => 'offer_com_usr',
            'password' => 'lnmsubct6d',
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
