<?php
/**
 * @var boolean $cartDone
 * @var boolean $paymentInfoDone
 */


if ($cartDone && !$paymentInfoDone) {
    $first = '<a class="step done" href="/cart">';
    $second = '<div class="step active">';
    $endFirst = '</a>';
} else if ($cartDone && $paymentInfoDone) {
    $first = '<div class="step done">' ;
    $second = '<div class="step done">';
    $endFirst = '</div>';
} else {
    $first = '<div class="step active">';
    $second = '<div class="step">';
    $endFirst = '</div>';
}

$endSecond = '</div>';

?>
<div class="progress-steps mb-5 mt-5">
    <?= $first ?>
        <span class="number">
            <?= $cartDone ? '<span class="material-symbols-outlined">check</span>' : '1' ?>
        </span>
        <span class="text">
            Cart
        </span>
        <span class="spacer"></span>
    <?= $endFirst ?>

    <?= $second ?>
        <span class="number">
            <?= $cartDone && $paymentInfoDone ? '<span class="material-symbols-outlined">check</span>' : '2' ?>
        </span>
        <span class="text">Payment</span>
        <span class="spacer"></span>
    <?= $endSecond ?>
    <?= $cartDone && $paymentInfoDone ? '<div class="step active">' : '<div class="step">' ?>
        <span class="number">3</span>
        <span class="text">Summary</span>
    </div>
</div>
