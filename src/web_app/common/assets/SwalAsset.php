<?php

namespace common\assets;

use yii\web\AssetBundle;

class SwalAsset extends AssetBundle
{
    public $sourcePath = '@common/assets';

    public $css = [
        'css/sweetalert2.min.css'
    ];

    public $js = [
        'js/sweetalert2.all.min.js',
        'js/swal.js'
    ];

}