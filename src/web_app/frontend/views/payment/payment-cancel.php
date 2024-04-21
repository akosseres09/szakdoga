<?php
/**
 * @var View $this
 * @var Session $session
 */


use frontend\assets\CartAsset;
use Stripe\Checkout\Session;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Cancelled Payment';

CartAsset::register($this);
?>

<?=
$this->render('/cart/_cart-steps', [
    'cartDone' => true,
    'paymentInfoDone' => true,
    'cancelled' => true
]);

?>

<div class="container-fluid">
    <div class="container">
        <?= $this->render('/common/_empty_text', [
            'title' => 'Cancelled Payment!',
            'text' => 'Go to payment page if you want to re-initiate payment!',
            'icon' => false,
            'link' => Url::to(['/payment']),
            'linkText' => 'Go to Payment'
        ]) ?>
    </div>
</div>