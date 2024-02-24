<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SwalAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/sweetalert2.min.css'
    ];

    public $js = [
        'js/sweetalert2.all.min.js'
    ];

}