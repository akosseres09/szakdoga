<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class CartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/cart/cart.css'
    ];

    public $js = [
        'js/cart/cart.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        '\common\assets\SwalAsset'
    ];
}