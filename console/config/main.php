<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        /*
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=go',
            'username' => 'root',
            'password' => '1234567890',
            'charset' => 'utf8',
        ],
         */
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=rds3ubryejizzya.mysql.rds.aliyuncs.com;dbname=ryyt39m9q752w2v7',
            'username' => 'ryyt39m9q752w2v7',
            'password' => '8gp5kmn9A',
            'charset' => 'utf8',
        ],
        'memcache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ],
    ],
    'params' => $params,
];
