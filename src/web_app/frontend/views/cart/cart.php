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
                        'itemView' => '_cartItem',
                        'pager' => [
                            'class' => LinkPager::class
                        ],
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
                <div class="row">
                    <span class="fw-semibold fs-4">Summary</span>
                    <div class="py-2 mt-2 cart-page-grey-container-summary" >
                        <div class="summary-container p-3">
                            <div class="summary-row">
                                <span class="fw-light">Official Price:</span>
                                <span id="official-price" class="fw-light">$<?= $total ?></span>
                            </div>
                            <div class="summary-row">
                                <span class="fw-light">Discount:</span>
                                <span id="discount" class="fw-light">$0</span>
                            </div>
                            <div class="summary-row">
                                <span class="fw-bold">Subtotal:</span>
                                <span id="subtotal" class="fw-bold fs-5">$<?= $total ?></span>
                            </div>
                            <a href="<?= $totalCount === 0 ? '#' : Url::to(['/cart/payment-info']) ?>" class="btn go-to-payment-info <?= $total === 0 ? 'btn-disabled' : '' ?>">Payment Information
                                <span class="ps-2 material-symbols-outlined">
                                    chevron_right
                                </span>
                            </a>
                            <span class="choice">or</span>
                            <a href="<?= Url::to(['/shop/products']) ?>" class="continue-shopping fw-light">
                                <span class="pe-2 material-symbols-outlined">
                                    chevron_left
                                </span>
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>