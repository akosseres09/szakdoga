<?php
/**
 * @var boolean $cartDone
 * @var boolean $paymentInfoDone
 */
?>
<div class="progress-steps mb-5 mt-5">
    <?= $cartDone ? '<a class="step done" href="/cart/cart">' : '<div class="step active">' ?>
        <span class="number">
            <?= $cartDone ? '<span class="material-symbols-outlined">check</span>' : '1' ?>
        </span>
        <span class="text">
            Shopping cart
        </span>
        <span class="spacer"></span>
    <?= $cartDone ? '</a>' : '</div>' ?>

    <?= $cartDone ? $paymentInfoDone ? '<a class="step done" href="/cart/payment-info">' : '<div class="step active">' : '<div class="step">' ?>
        <span class="number">
            <?= $cartDone && $paymentInfoDone ? '<span class="material-symbols-outlined">check</span>' : '2' ?>
        </span>
        <span class="text">Payment Information</span>
        <span class="spacer"></span>
    <?= $cartDone && $paymentInfoDone ? '</a>' : '</div>' ?>
    <?= $cartDone && $paymentInfoDone ? '<div class="step active">' : '<div class="step">' ?>
        <span class="number">3</span>
        <span class="text">Payment</span>
    </div>
</div>