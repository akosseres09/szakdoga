<?php
/**
 * @var View $this
 * @var Product $product
 * @var Cart $cart
 */

use common\components\WishlistHelper;
use common\models\Cart;
use common\models\Product;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

$images = $product->getImages();
$inWishlist = WishlistHelper::isInWishlist(Yii::$app->user->id, $product->id);

// css and js for zooming on hover

$this->registerCss(<<<CSS
    .carousel-item img {
        -o-object-fit: cover;
        object-fit: cover;
        transform: scale(var(--zoom, 1));
        transform-origin: var(--x) var(--y);
        transition: transform 0.3s ease;
    }

    .carousel-item img:hover {
        --zoom: 2;
    }
CSS);

$this->registerJsFile('/js/shop/carouselImgZoomer.js');

?>

<div class="row">
    <h1>
        <?=$product->brand->name . ' ' . $product->name ?>
    </h1>
</div>
<div class="row mt-3">
    <div class="col-lg-7 col-12">
        <div id="productPicsCarouselDesktop" class="carousel slide d-none d-lg-flex justify-content-lg-between" data-bs-touch="true">
            <div class="carousel-inner order-lg-2">
                <?php foreach ($images as $index => $image) {?>
                    <div class="carousel-item text-center <?= $index === 0 ? 'active' : ''?>">
                        <img alt="" src="/storage/images/<?=$product->folder_id . '/' . $image?>">
                    </div>
                <?php  }?>
            </div>
            <div class="d-none d-lg-block desktop-indicators">
                <div class="carousel-indicators" style="position:relative;">
                    <?php foreach ($images as $index => $image) { ?>
                        <div class="row">
                            <button type="button" data-bs-target="#productPicsCarouselDesktop" data-bs-slide-to="<?=$index?>" <?= $index === 0 ? 'class="active"' : ''?> aria-current="true" aria-label="Slide <?=$index?>">
                                <img alt="" src="/storage/images/<?=$product->folder_id . '/' . $image?>">
                            </button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div id="productPicsCarouselMobile" class="carousel slide d-block d-lg-none justify-content-lg-between" data-bs-touch="true">
        <div class="carousel-inner order-lg-2">
            <?php foreach ($images as $index => $image) {?>
                <div class="carousel-item text-center <?= $index === 0 ? 'active' : ''?>">
                    <img alt="" src="/storage/images/<?=$product->folder_id . '/' . $image?>">
                </div>
            <?php  }?>
        </div>
        <div class="mobile-indicators">
            <div class="carousel-indicators mt-4">
                <?php foreach ($images as $index => $image) { ?>
                    <button type="button" data-bs-target="#productPicsCarouselMobile" data-bs-slide-to="<?=$index?>" <?= $index === 0 ? 'class="active"' : ''?> aria-current="true" aria-label="Slide <?=$index?>"></button>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-lg-5 p-3" style="border-radius: 10px">
        <?php $form = ActiveForm::begin([
                'id' => 'place-in-cart-form',
                'action' => ['/shop/add-to-cart'],
                'enableClientValidation' => true,
            ]
        ) ?>
        <div class="row">
            <span class="fs-5 fw-bold">
                <?= $product->brand_name .' '.  $product->name ?>
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
                    <h6>
                        <?= Product::SIZE[$product->isKid()] ?> Size Table
                    </h6>
                </div>
                <div class="row mt-3 size-picker">
                    <div class="size-container">
                        <?php
                            if (!$product->isShoe()) {
                                foreach (Cart::SHIRT_SIZES as $size) { ?>
                                    <div class="p-2 size-item"><?= $size ?></div>
                                <?php } ?>
                            <?php } else { ?>
                                <?php if(!$product->isKid()) { ?>
                                    <?php foreach (Cart::ADULT_SIZES as $size) { ?>
                                        <div class="p-2 size-item"><?= $size ?></div>
                                <?php } ?>
                                <?php } else { ?>
                                    <?php foreach (Cart::KID_SIZES as $size) { ?>
                                        <div class="p-2 size-item"><?= $size ?></div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                    </div>
                </div>
                <?= $form->field($cart, 'size')->hiddenInput(['required' => true])->label('') ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-auto">
                <?php if ($product->hasOnStock()) { ?>
                    <span class="w-100 px-4 badge text-bg-success fw-bold fs-6"><?= $product->number_of_stocks ?> Left on Stock</span>
                <?php } else { ?>
                    <span class="w-100 px-4 badge text-bg-danger fw-bold fs-6"> Unavailable </span>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->field($cart, 'quantity')->textInput(['type' => 'number', 'min' => 1, 'max' => $product->number_of_stocks, 'required' => true, 'value' => 1]) ?>
            </div>
            <div class="col-sm-4 ms-0 ms-sm-4 mt-0 mt-sm-4">
                <div class="col-2 d-flex justify-content-start justify-content-sm-end align-items-end">
                    <?php if($inWishlist) { ?>
                        <a href="<?= Url::to(['/shop/remove-from-wishlist/'.$product->id]) ?>" class="wishlist-link">
                            <span class="material-symbols-outlined wishlist-btn active">
                                favorite
                            </span>
                        </a>
                    <?php } else { ?>
                        <a href="<?= Url::to(['/shop/add-to-wishlist/'.$product->id]) ?>" class="wishlist-link">
                            <span class="material-symbols-outlined wishlist-btn">
                                favorite
                            </span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col d-flex align-items-center">
                <?php if (!$product->hasOnStock() && $product->isShoe()) {?>
                    <button type="button" class="btn btn-outline-dark">Notify me when On Stock</button>
                <?php } else if($product->isActivated()) { ?>
                    <button type="submit" class="btn btn-primary">Place in Cart</button>
                <?php } ?>
            </div>
        </div>
    </div>
    <input type="hidden" name="product_id" value="<?= $product->id ?>">
    <?php ActiveForm::end() ?>
</div>