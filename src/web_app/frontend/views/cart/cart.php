<?php

use frontend\assets\CartAsset;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var ActiveDataProvider $cartItems
 * @var int $totalCount
 * @var int $total
 */

$this->title = 'Cart - Sportify';

CartAsset::register($this);

if (Yii::$app->session->getFlash('emptyCart')) {
    $this->registerJs(<<<JS
        showCartSwal();
JS, View::POS_END);
}
?>

<?= $this->render('/site/common/_alert') ?>

<?= $this->render('_cart-steps', [
    'cartDone' => false,
    'paymentInfoDone' => false
]) ?>

<div class="container-fluid mt-3">
    <div class="container cart">
        <div class="cart-page-container">
            <div class="cart-page-left">
                <span class="fw-semibold fs-4">Cart</span>
                <div class="py-2 mt-2 cart-page-grey-container">
                    <?=
                    ListView::widget([
                        'dataProvider' => $cartItems,
                        'layout' => '{items}',
                        'itemView' => '_cartItem',
                        'emptyText' => '<div class="d-flex flex-column justify-content-center align-items-center gap-4 p-5">
                        <div class="cart-icon icon-xxl"></div>
                        <span class="fs-4 fw-semibold">Your cart is empty</span>
                        <span class="fw-light fs-5 text-center" >You didn\'t add any item in your cart yet. Browse the website to find amazing deals!</span>
                        <a href="/shop/products" class="btn btn-outline-dark px-4 py-2">
                            <span class="fs-5">Browse Products</span>
                        </a>
                    </div>',
                        'summary' => '',
                        'viewParams' => [
                            'total' => $cartItems->totalCount
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="cart-page-right">
                <?= $this->render('_cart-page-right', [
                    'total' => $total,
                    'totalCount' => $totalCount
                ]) ?>
            </div>
        </div>
    </div>
</div>