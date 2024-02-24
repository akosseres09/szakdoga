<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ShopAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/shop/shop.css'
    ];

    public $js = [
        'js/shop/shop.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        '\frontend\assets\SwalAsset'
    ];
}