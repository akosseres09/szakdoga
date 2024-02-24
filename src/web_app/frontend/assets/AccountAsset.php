<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AccountAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
      'css/site/account.css'
    ];

    public $js = [];

    public $depends = [
      '\frontend\assets\SwalAsset'
    ];
}