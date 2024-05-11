<?php

namespace common\assets;

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

    public $publishOptions = [
        'forceCopy' => true
    ];
}