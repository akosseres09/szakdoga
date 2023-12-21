<?php

use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var $products ArrayDataProvider
 */

$this->title = 'Products Admin  »  Sportify';

echo $this->render('/site/common/_alert');

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
                        <div class="d-flex justify-content-center justify-content-lg-start flex-wrap gap-3">{items}</div>
                        {pager}
                    </div>
                    <div class="text-center mt-2">{summary}</div>
                </div>'
]);
?>
<a class="position-fixed add-new-btn" id="addModalToggler" data-bs-target="#addModal" data-bs-toggle="modal">
    <span class="material-symbols-outlined">
        add
    </span>
</a>

<div id="addModal" class="modal modal-lg fade" tabindex="-1">
    <div class="modal-dialog">
    </div>
</div>

<div id="productEditModal" class="modal modal-lg fade" tabindex="-1">
    <div class="modal-dialog">
    </div>
</div>