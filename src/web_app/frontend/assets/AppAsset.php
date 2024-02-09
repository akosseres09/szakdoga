<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/header.css',
        'css/google.css',
        'css/footer.css',
        'css/font-awesome.min.css',
        'css/landing.css',
        'css/shop.css'
    ];
    public $js = [
        'js/app.js',
        'js/HeaderManager.js',
        'js/bootstrap.bundle.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}