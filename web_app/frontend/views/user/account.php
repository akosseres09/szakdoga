<?php
/**
 * @var View $this
 * @var User $user
 * @var BillingInformation $billingInfo
 * @var ShippingInformation $shippingInfo
 */

use common\models\BillingInformation;
use common\models\ShippingInformation;
use common\models\User;
use yii\web\View;

$this->title = 'Your Account';
?>

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row justify-content-evenly">
        <?=
            $this->render('_profileCard', [
                    'user' => $user
            ])
        ?>
        <?=
            $this->render('_billingInfoForm', [
                    'billingInfo' => $billingInfo
            ]);
        ?>
        <?=
            $this->render('_shippingInfoForm', [
                    'shippingInfo' => $shippingInfo
            ]);
        ?>
    </div>
</div>