<?php

namespace common\assets;

use yii\web\AssetBundle;

class OrderAsset extends AssetBundle
{
    public $sourcePath = '@common/assets';

    public $css = [
        'css/order.css',
    ];

    public $publishOptions = [
        'forceCopy' => true
    ];
}