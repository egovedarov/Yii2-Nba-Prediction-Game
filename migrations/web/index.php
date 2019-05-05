<?php

// comment out the following two lines when deployed to production
define('YII_DEBUG', file_exists(__DIR__ . '/../config/debug'));
defined('YII_ENV') or define('YII_ENV', require(__DIR__ . '/../config/env.php'));

require __DIR__ . '/../vendor/autoload.php';
//require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

// Define Yii class.
class Yii extends \app\components\Yii {}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = include(__DIR__ . '/../vendor/yiisoft/yii2/classes.php');
Yii::$container = new yii\di\Container;
require_once __DIR__ . '/../config/di.php';
(new \app\components\WebApplication($config))->run();
