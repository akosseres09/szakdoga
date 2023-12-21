<?php
/**
 * @var View $this
 * @var Product $product
 */

use common\models\Product;
use yii\web\View;

$this->title = $product->name . ' - Sportify';

?>

<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <h1>
                <?= $product->name ?>
            </h1>
        </div>
        <div class="row">
            <div class="col-1 d-flex flex-column justify-content-around">
                <div class="row">
                        <img src="/storage/profile-pics/default_pic.jpg">
                </div>
                <div class="row">
                    <img src="/storage/profile-pics/default_pic.jpg">
                </div>
                <div class="row">
                    <img src="/storage/profile-pics/default_pic.jpg">
                </div>
                <div class="row">
                    <img src="/storage/profile-pics/default_pic.jpg">
                </div>
                <div class="row">
                    <img src="/storage/profile-pics/default_pic.jpg">
                </div>
            </div>
            <div class="col-7">
                <img src="/storage/profile-pics/default_pic.jpg" style="width: 60%">
            </div>
            <div class="col-lg-4" style="background-color: lightgrey; border-radius: 10px">
                <div class="row p-3 align-items-center">
                    <span class="col fs-4">Price</span>
                    <span class="col-auto fs-5 fw-bold">$<?= $product->price ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
