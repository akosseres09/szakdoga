<?php

namespace common\widgets;

use yii\bootstrap5\LinkPager;

class Pager extends LinkPager
{
    public $options = [
        'class' => [
            'pagination mt-3 d-flex justify-content-center align-items-center'
        ]
    ];
}