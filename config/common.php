<?php

use app\components\SimplicateService;
use app\components\SlackService;
use app\components\UniFiService;
use yii\helpers\ArrayHelper;

include __DIR__ . '/../helpers/functions.php';

$result = [
    'id' => 'Nba Prediction Game',
    'name' => 'Nba Prediction Game',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'params' => $params,
    'components' => [
        'formatter' => [
            'class' => \yii\i18n\Formatter::class,
            'defaultTimeZone' => 'Europe/Amsterdam'
        ]
    ]
];

if (defined('YII_ENV') && file_exists(__DIR__ . '/envs/' . YII_ENV . '.php')) {
    $result = ArrayHelper::merge($result, include(__DIR__ . '/envs/' . YII_ENV . '.php'));
}

if (file_exists(__DIR__ . '/local.php')) {
    define('YII_LOCAL', true);
    $result = ArrayHelper::merge($result, include(__DIR__ . '/local.php'));
} else {
    define('YII_LOCAL', false);
}

return $result;