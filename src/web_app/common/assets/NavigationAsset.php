<?php

namespace common\assets;

use backend\assets\AppAsset;
use yii\web\AssetBundle;

class NavigationAsset extends AssetBundle
{
    public $sourcePath = '@common/assets';

    public $css = [
        'css/navigation.css',
    ];

    public $js = [
        'js/navigation.js',
    ];

    public $depends = [
        AppAsset::class
    ];

    public $publishOptions = [
        'forceCopy' => true
    ];
}