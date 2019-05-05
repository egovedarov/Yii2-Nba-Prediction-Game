<?php

namespace app\assets\popup;

use app\assets\loader\LoaderAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class PopupAsset extends AssetBundle
{
    public $css = [
        'css/popup.css'
    ];

    public $js = [
        'js/popup.js'
    ];

    public $depends = [
        JqueryAsset::class,
        LoaderAsset::class
    ];

    public $sourcePath = __DIR__ . '/assets';
}