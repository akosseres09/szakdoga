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
            <div class="col-lg-8 col-12">
                <div id="productPicsCarousel" class="carousel slide" data-bs-touch="true">
                    <div class="carousel-inner">
                        <div class="carousel-item active text-center">
                            <img src="/storage/profile-pics/default_pic.jpg" >
                        </div>
                        <div class="carousel-item text-center">
                            <img src="/storage/profile-pics/default_pic.jpg" >
                        </div>
                        <div class="carousel-item text-center">
                            <img src="/storage/profile-pics/default_pic.jpg" >
                        </div>
                    </div>

                   <div class="d-block d-lg-none">
                       <button class="carousel-control-prev" type="button" data-bs-target="#productPicsCarousel" data-bs-slide="prev">
                           <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                           <span class="visually-hidden">Previous</span>
                       </button>

                       <button class="carousel-control-next" type="button" data-bs-target="#productPicsCarousel" data-bs-slide="next">
                           <span class="carousel-control-next-icon" aria-hidden="true"></span>
                           <span class="visually-hidden">Next</span>
                       </button>

                   </div>
                    <div class="d-none d-md-block">
                        <div class="carousel-indicators mt-4" style="position:relative;">
                            <button type="button" data-bs-target="#productPicsCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>

                            <button type="button" data-bs-target="#productPicsCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#productPicsCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                    </div>
                </div>
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
