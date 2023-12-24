<?php
/**
 * @var View $this
 * @var Product $product
 * @var Cart $cart
 */

use common\models\Cart;
use common\models\Product;
use yii\web\View;
use yii\bootstrap5\ActiveForm;

$this->title = $product->name . ' - Sportify';
$images = $product->getImages();
?>

<?= $this->render('/site/common/_alert') ?>

<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <h1>
                <?=$product->brand->name . ' ' . $product->name ?>
            </h1>
        </div>
        <div class="row mt-3">
            <div class="col-lg-8 col-12">
                <div id="productPicsCarousel" class="carousel slide" data-bs-touch="true">
                    <div class="carousel-inner">
                        <?php foreach ($images as $index => $image) {?>
                            <div class="carousel-item text-center <?= $index === 0 ? 'active' : ''?>">
                                <img src="/storage/images/<?=$product->folder_id . '/' . $image?>">
                            </div>
                        <?php  }?>
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
                            <?php foreach ($images as $index => $image) { ?>
                                <button type="button" data-bs-target="#productPicsCarousel" data-bs-slide-to="<?=$index?>" <?= $index === 0 ? 'class="active"' : ''?> aria-current="true" aria-label="Slide <?=$index?>"></button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-3" style="border-radius: 10px">
                <?php $form = ActiveForm::begin([
                        'id' => 'place-in-cart-form',
                        'action' => ['/shop/add-to-cart'],
                        'enableClientValidation' => true,
                    ]
                ) ?>
                <div class="row">
                    <span class="fs-5 fw-bold">
                        <?= $product->brand->name .' '.  $product->name ?>
                        <?= $product->isKid() ? 'Children' : '' ?>
                    </span>
                    <div class="row mt-2">
                        <span class="fs-4 fw-bold">
                            $<?= $product->price ?>
                        </span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="row">
                            <span>
                                Size Table
                            </span>
                        </div>
                        <div class="row mt-4 size-picker">
                            <div class="col d-flex flex-wrap">
                                <?php if(!$product->isKid()) { ?>
                                    <?php foreach (Cart::ADULT_SIZES as $size) { ?>
                                        <div class="p-2 size-item"><?= $size ?></div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php foreach (Cart::KID_SIZES   as $size) { ?>
                                        <div class="p-2 size-item"><?= $size ?></div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <?= $form->field($cart, 'size')->hiddenInput(['required' => true])->label('') ?>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <?= $form->field($cart, 'quantity')->textInput(['type' => 'number', 'min' => 1, 'required' => true, 'value' => 1]) ?>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col d-flex">
                        <?php if (!$product->hasOnStock() && $product->isShoe()) {?>
                            <button class="btn btn-outline-light">Notify me when On Stock</button>
                        <?php } else { ?>
                                <div class="col d-flex align-items-start">
                                    <button type="submit" data-bs-target="#addToCartModal" data-bs-toggle="modal" class="btn btn-primary">Place in Cart</button>
                                </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <input type="hidden" name="product_id" value="<?= $product->id ?>">
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

<div id="addToCartModal" class="modal">
    <div class="modal-dialog">

    </div>
</div>

<div id="loader-overlay" class="d-none">
    <div id="loader"></div>
</div>
