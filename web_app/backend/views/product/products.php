<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var $products ArrayDataProvider
 */

?>

<div class="product-container mx-5" style="background-color: darkgray; border-radius: 10px; padding: 15px 30px">
    <div class="row justify-content-between border-bottom pb-2">
        <div class="col-8 align-items-center">
            <div class="col-auto fs-5">
                Soccer Ball
            </div>
            <div class="col-auto">
                1
            </div>
            <div class="col-auto">
                On stock
            </div>
        </div>
        <div class="col-auto fs-5">
            $15
        </div>
    </div>
    <div class="row">
        <div class="col">

        </div>
    </div>
</div>

<div class="container-fluid position-relative">
    <?=
    GridView::widget([
        'dataProvider' => $products,
        'columns' => [
            'id',
            'name',
            'price',
            'rating',
            'number_of_stocks',
            'is_activated'
        ],
        'options' => ['class' => 'mx-5 table-responsive'],
        'tableOptions' => ['class' => 'table table-striped text-center align-middle'],
        'pager' => [
                'class' => LinkPager::class
        ],
        'layout' => '<div class="table-responsive">{items}</div>{pager}'
    ])
    ?>
</div>
<a class="position-absolute add-new-btn" href="<?= Url::to(['/product/add']) ?>">
    <span class="material-symbols-outlined">
        add
    </span>
</a>
