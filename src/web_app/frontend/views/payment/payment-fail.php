<?php
/**
 * @var View $this
 */


use frontend\assets\CartAsset;
use yii\web\View;

$this->title = 'Cancelled Payment';

CartAsset::register($this);
?>

<?=
    $this->render('/cart/_cart-steps', [
        'cartDone' => true,
        'paymentInfoDone' => true,
        'cancelled' => true
    ])
?>

<div class="container-fluid">
    <div class="container">

    </div>
</div>