<?php

use app\models\activeRecord\User;
use kartik\grid\Module;
use yii\caching\FileCache;
use yii\helpers\ArrayHelper;
use yii\log\FileTarget;
use yii\swiftmailer\Mailer;
use yii\web\User as UserComponent;

$params = require __DIR__ . '/params.php';
$result = include __DIR__ . '/common.php';

$result = ArrayHelper::merge($result, [
    'defaultRoute' => '/site',
    'homeUrl' => ['/site'],
    'bootstrap' => [],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'pJs7VgvKfb4ak$aWWxz1W2uQF4cu94y8',
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'user' => [
            'identityClass' => User::class,
            'class' => UserComponent::class,
            'enableAutoLogin' => false,
            'enableSession' => true,
            'loginUrl' => ['session/login'],
            'authTimeout' => 3600
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => Mailer::class,
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
				'' => 'site/index',                                
				'<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
			],
        ],
    ],
    'modules' => [
        'gridview' => [
            'class' => Module::class
        ]
    ],
    'params' => $params,
]);

if (YII_DEBUG && file_exists(__DIR__ . '/debug.php')) {
    $result = ArrayHelper::merge($result, include(__DIR__ . '/debug.php'));
}

return $result;
