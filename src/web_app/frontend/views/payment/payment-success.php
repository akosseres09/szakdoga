<?php


use frontend\assets\CartAsset;

CartAsset::register($this);

echo $this->render('/cart/_cart-steps', [
    'cartDone' => true,
    'paymentInfoDone' => true
])
?>
