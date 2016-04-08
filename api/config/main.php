<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'api\models\Frontuser',
            //'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
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
            'errorAction' => 'index/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            //'enableStrictParsing' => true,
            'rules' => ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
        ],
        'rediscache' => [
               'class' => 'yii\redis\Cache',
               'redis' => [
                    'hostname' => 'redis',
                    'port' => 6379,
                    'database' => 0,
               ],
        ],
        'memcache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'memcached',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ],
    ],
    'params' => $params,
];
