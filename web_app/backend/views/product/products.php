<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var $products ArrayDataProvider
 */

$this->title = 'Products Admin  »  Sportify';

echo '<h1 class="text-center mb-4">Products</h1>';

echo ListView::widget([
    'dataProvider' => $products,
    'pager' => [
        'class' => LinkPager::class
    ],
    'emptyText' => 'No result found',
    'emptyTextOptions' => ['class' => 'fs-4 fw-bold'],
    'itemView' => '_item',
    'summary' => '{begin}-{end}/{totalCount}',
    'itemOptions' => ['class' => 'card product-container'],
    'layout' => '<div class="container-fluid position-relative">
                    <div class="container">
                        <div class="d-flex flex-wrap gap-3">{items}</div>
                        {pager}
                    </div>
                    <div class="text-center mt-2">{summary}</div>
                </div>'
]);
?>
<a class="position-absolute add-new-btn" href="<?= Url::to(['/product/add']) ?>">
    <span class="material-symbols-outlined">
        add
    </span>
</a>
