<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class WishlistAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/shop/shop.css'
    ];

    public $js = [];

    public $depends = [
        '\frontend\assets\SwalAsset',
        'yii\web\YiiAsset'
    ];
}