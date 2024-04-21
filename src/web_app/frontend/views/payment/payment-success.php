<?php

/**
 * @var View $this
 */

use frontend\assets\CartAsset;
use yii\web\View;

CartAsset::register($this);

$this->title = 'Successful Payment';

echo $this->render('/cart/_cart-steps', [
    'cartDone' => true,
    'paymentInfoDone' => true
]);

?>

<div class="container-fluid">
    <div class="container">
        <?= $this->render('/common/_empty_text', [
            'title' => 'Successful Payment',
            'text' => 'Your payment was successful. The ordered products are being processed! Thank you for the purchase!',
            'icon' => false,
        ]) ?>
    </div>
</div>
