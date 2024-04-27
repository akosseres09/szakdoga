<?php
/**
 * @var View $this
 */


use frontend\assets\CartAsset;
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
    ])
?>

<div class="container-fluid">
    <div class="container">
        <?= $this->render('/common/_empty_text', [
            'title' => 'Error While Paying!',
            'text' => 'Your payment was unsuccessful. Please try again later.!',
            'icon' => false,
            'linkText' => 'Back to Cart',
            'link' => Url::to(['/cart'])
        ]) ?>
    </div>
</div>