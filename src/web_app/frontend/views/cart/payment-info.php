<?php
/**
 * @var View $this
 * @var BillingInformation $billing
 * @var ShippingInformation $shipping
 * @var ActiveDataProvider $products
 * @var int $total
 */

use common\models\BillingInformation;
use common\models\ShippingInformation;
use frontend\assets\CartAsset;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\bootstrap5\ActiveForm;


CartAsset::register($this);
$this->registerJsFile('/js/payment/payment.js');
$this->title = 'Payment';

$this->registerCssFile('/css/payment/payment.css');

?>

<?= $this->render('/site/common/_alert') ?>

<?= $this->render('_cart-steps', [
    'cartDone' => true,
    'paymentInfoDone' => false
]) ?>

<div class="container-fluid mt-3">
    <div class="container">
        <div class="w-100">
            <?php $form = ActiveForm::begin([
                'id' => 'payment-form',
                'method' => 'post',
                'action' => '/cart/pay',
                'options' => [
                    'class' => 'd-flex align-items-start',
                ]
            ]) ?>
                <div class="platforms">
                    <?= $this->render('/payment/_payment_billing', [
                        'billing' => $billing,
                        'form' => $form
                    ]) ?>
                    <?= $this->render('/payment/_payment_shipping', [
                        'shipping' => $shipping,
                        'form' => $form
                    ]) ?>
                </div>
                <div class="panel">
                    <?= $this->render('/payment/_payment_summary', [
                        'products' => $products
                    ]) ?>
                    <?= $this->render('/payment/_payment_button', [
                        'total' => $total
                    ]) ?>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
