<?php

$params = require __DIR__ . '/params.php';

$configLocal = require __DIR__ . '/web-local.php';

$db = require __DIR__ . '/db.php';
$dbLocal = require __DIR__ . '/db-local.php';

$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => \api\modules\v1\Module::class
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@api'   => dirname(dirname(__DIR__)) . '/api',
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ]
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
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
        'db' => array_merge($db + $dbLocal),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'controller' => ['v1/media'],
                    'class' => \yii\rest\UrlRule::class,
                ],
            ],
        ],

    ],
    'params' => $params,
];

return array_merge_recursive($configLocal, $config);
