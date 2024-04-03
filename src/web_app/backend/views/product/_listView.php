<?php
/**
 * @var ActiveDataProvider $products
 * @var View $this
 */

use common\widgets\Pager;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;
use yii\widgets\Pjax;

Pjax::begin([
    'enablePushState' => false,
    'enableReplaceState' => false
]);
echo ListView::widget([
    'dataProvider' => $products,
    'pager' => [
        'class' => Pager::class,
    ],
    'emptyText' => '<h1 class="fs-5 fw-bold text-center">No Products in the Database</h1>',
    'itemView' => '_item',
    'itemOptions' => ['class' => 'card product-container product-item-link'],
    'summary' => false,
    'layout' => '<div class="container-fluid position-relative">
                    <div class="text-center mb-2">{summary}</div>
                    <div class="container">
                        <div class="items-grid-container">{items}</div>
                        {pager}
                    </div>
                </div>'
]);
Pjax::end();



