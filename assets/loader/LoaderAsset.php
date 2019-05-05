<?php

namespace app\assets\loader;

use yii\web\JqueryAsset;

class LoaderAsset extends \yii\web\AssetBundle
{
    public $css = [
        'css/loader.css'
    ];

    public $js = [
        'js/loader.js'
    ];

    public $depends = [
        JqueryAsset::class
    ];

    public $sourcePath = __DIR__ . '/assets';
}