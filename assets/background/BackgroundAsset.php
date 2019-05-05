<?php

namespace app\assets\background;


use app\assets\AppAsset;
use yii\web\AssetBundle;

class BackgroundAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets';

    public $css = [
        'css/background.css',
    ];
    public $js = [
    ];
    public $depends = [
        AppAsset::class
    ];
}