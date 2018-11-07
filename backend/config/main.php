<?php
$params = array_merge(
    require __DIR__.'/../../common/config/params.php',
    require __DIR__.'/../../common/config/params-local.php',
    require __DIR__.'/params.php',
    require __DIR__.'/params-local.php'
);

return [
    'id' => 'app-backend',
    'language' => 'ru-RU',
    'aliases' =>[
        '@images' => '/var/www/youoffer.com/data/www/youoffer.com',
    ],
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['213.176.233.106', '127.0.0.1', '::1', '91.240.208.186'],
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['admin', 'product', 'manager', 'guest'],
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => "backend/web",
                    'basePath' => '/backend/web',
                    'baseUrl' => '/backend/web',
                    'css' => ['css/bootstrap.min.css'],
                ],
            ],
            'assetMap' => [
//                'npm.js' => 'http://youoffer.com/backend/web/assets/63d75d9c/js/npm.js',
//                'core.js' => 'http://youoffer.com/backend/web/assets/666f76be/core.js',
                // 'yii.js' => 'http://youoffer.com/vendor/yiisoft/yii2/assets/yii.js',
//                'yii.gridView.js' => 'http://youoffer.com/backend/web/assets/b0c1950/yii.gridView.js',
//                'yii.activeForm.js' => 'http://youoffer.com/backend/web/assets/b0c1950/yii.activeForm.js',
//                'yii.captcha.js' => 'http://youoffer.com/backend/web/assets/b0c1950/yii.captcha.js',
//                'yii.validation.js' => 'http://youoffer.com/backend/web/assets/b0c1950/yii.validation.js',
//                'jquery.js' => 'http://youoffer.com/backend/web/assets/666f76be/jquery.js',
//                'bootstrap.js' => 'http://youoffer.com/backend/web/assets/63d75d9c/js/bootstrap.js',
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'multipart/form-data' => 'yii\\web\\MultipartFormDataParser',
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=youoffer_com_db',
            'username' => 'youoffer_com_usr',
            'password' => 'lnmsubct6d',
            'charset' => 'utf8',
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '' => 'site/index',
                'catalog' => 'catalog/index',
                'currency' => 'currency/index',
                'users' => 'users/index',
                'settings' => 'settings/index',
                'brands' => 'brands/index',
                'merch' => 'merch/index',
                'products' => 'products/index',
                'parsers' => 'site/parsers'
            ],
        ],

    ],
    'params' => $params,
];
