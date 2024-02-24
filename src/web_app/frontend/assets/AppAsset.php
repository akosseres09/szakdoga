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
        'css/site/site.css',
        'css/site/header.css',
        'css/site/google.css',
        'css/site/footer.css',
        'css/site/font-awesome.min.css',
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
