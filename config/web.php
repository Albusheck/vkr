<?php

$params = require __DIR__ . '/params.php';

return [
    'id' => 'calculator-yii2',
    'name' => 'Калькулятор',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'sF6ugQqWMYrNL4Q',
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'POST /api/v2/months' => 'api/v2/months/create',
                'GET /api/v2/months' => 'api/v2/months/index',
                'DELETE /api/v2/months' => 'api/v2/months/delete',
                'OPTIONS /api/v2/months' => 'api/v2/months/options',
                'POST /api/v2/tonnages' => 'api/v2/tonnages/create',
                'GET /api/v2/tonnages' => 'api/v2/tonnages/index',
                'DELETE /api/v2/tonnages' => 'api/v2/tonnages/delete',
                'OPTIONS /api/v2/tonnages' => 'api/v2/tonnages/options',
                'POST /api/v2/types' => 'api/v2/types/create',
                'GET /api/v2/types' => 'api/v2/types/index',
                'DELETE /api/v2/types' => 'api/v2/types/delete',
                'OPTIONS /api/v2/types' => 'api/v2/types/options',
                'POST /api/v2/prices' => 'api/v2/prices/create',
                'GET /api/v2/prices' => 'api/v2/prices/index',
                'DELETE /api/v2/prices' => 'api/v2/prices/delete',
                'OPTIONS /api/v2/prices' => 'api/v2/prices/options',
                'PATCH /api/v2/prices' => 'api/v2/prices/change',
                'calculator/validate' => 'calculator/validate',
                'calculator/register' => 'calculator/register',
                'calculator/login' => 'calculator/login',
                'calculator/logout' => 'calculator/logout',
                'calculator/hide-alert' => 'calculator/hide-alert',
                'calculator/users' => 'calculator/users',
                'calculator/profile' => 'calculator/profile',
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User', // Укажите ваш класс пользователя
            'enableAutoLogin' => true, // Опционально: включение авторизации через cookie
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true], // Настройки cookie
        ],
        'db' => require __DIR__ . '/db.php',
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
    ],
    'params' => $params,
];