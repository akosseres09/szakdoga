<?php

namespace common\widgets;


use yii\bootstrap5\LinkPager;

class Pager extends LinkPager
{
    public $options = [
        'class' => [
            'pagination mt-3 d-flex justify-content-center align-items-center'
        ],
    ];
    public $listOptions = [
        'class' => [
            'pagination custom-pagination'
        ]
    ];
    public $linkOptions = [
        'class' => [
            'page-link custom-page-link'
        ]
    ];
    public $linkContainerOptions = [
        'class' => [
            'page-item custom-page-item'
        ],
    ];
    public $nextPageLabel = '<span aria-hidden="true">&raquo;</span>';
    public $prevPageLabel = '<span aria-hidden="true">&laquo</span>';
}