<?php

use yii\rest\UrlRule;

$params = require __DIR__ . '/params.php';
$paramsLocal = require __DIR__ . '/params-local.php';
$db = require __DIR__ . '/db.php';
$dbLocal = require __DIR__ . '/db-local.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
//            'cookieValidationKey' => '',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
                'multipart/form-data' => yii\web\MultipartFormDataParser::class
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => array_merge($db, $dbLocal),
        'urlManager' => [
            'enablePrettyUrl' => true,
//            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [ 'controller' => [ 'v1/media'], 'class' => UrlRule::class, ],
                [ 'controller' => [ 'v1/auth'] , 'class' => UrlRule::class, ],
                [ 'controller' => [ 'v1/profile'], 'class' => UrlRule::class,  ],
                [ 'controller' => [ 'v1/users'] , 'class' => UrlRule::class, ],
                [ 'controller' =>
                    [ 'v1/like' ],
                    'class' => UrlRule::class,
                    'pluralize' => false,
                ],
                [ 'controller' => [ 'v1/comment'] , 'class' => UrlRule::class, 'pluralize' => false, ],
            ],
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => \app\modules\v1\Module::class
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return array_merge_recursive($paramsLocal, $config);
