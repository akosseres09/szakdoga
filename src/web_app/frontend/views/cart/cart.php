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
                        'emptyText' => $this->render('/common/_empty_text', [
                            'title' => 'Your cart is empty',
                            'text' => 'You didn\'t add any item in your cart yet. Browse the website to find amazing deals!'
                        ]),
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