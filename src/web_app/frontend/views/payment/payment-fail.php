<?php
/**
 * @var View $this
 */


use frontend\assets\CartAsset;
use yii\web\View;

CartAsset::register($this);
?>

<?=
    $this->render('/cart/_cart-steps', [
        'cartDone' => true,
        'paymentInfoDone' => true
    ])
?>
