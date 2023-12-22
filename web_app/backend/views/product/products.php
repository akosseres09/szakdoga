<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap5\LinkPager;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var $products ActiveDataProvider
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
    'emptyTextOptions' => ['class' => 'fs-5 fw-bold'],
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