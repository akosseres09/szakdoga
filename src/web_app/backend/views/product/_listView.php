<?php
/**
 * @var ActiveDataProvider $products
 * @var View $this
 */

use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;


echo ListView::widget([
    'dataProvider' => $products,
    'pager' => [
        'class' => LinkPager::class
    ],
    'emptyText' => '<h1 class="fs-5 fw-bold text-center">No Products in the Database</h1>',
    'itemView' => '_item',
    'itemOptions' => ['class' => 'card product-container product-item-link'],
    'summary' => '{begin}-{end}/{totalCount}',
    'layout' => '<div class="container-fluid position-relative">
                    <div class="container">
                        <div class="items-grid-container">{items}</div>
                        {pager}
                    </div>
                    <div class="text-center mt-2">{summary}</div>
                </div>'

]);



