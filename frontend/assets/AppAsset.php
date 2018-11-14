<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '/frontend/web';
    public $baseUrl = '/frontend/web';
    public $css = [
        'css/style.css',
        'css/bootstrap.min.css'
    ];
    public $js = [
        'js/main.js',
        'https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js',
        'js/components.js',


    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
}
