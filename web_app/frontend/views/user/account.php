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

$this->registerCssFile('@web/css/account.css');
$this->title = 'Your Account';
?>

<?=
$this->render('/site/common/_alert'); ?>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row justify-content-evenly">
        <?=
            $this->render('_profileCard', [
                    'user' => $user
            ])
        ?>
        <?=
            $this->render('_billingInfo', [
                    'billingInfo' => $billingInfo
            ]);
        ?>
        <?=
            $this->render('_shippingInfo', [
                    'shippingInfo' => $shippingInfo
            ]);
        ?>
    </div>
</div>

<div id="userEditModal" class="modal modal-lg">
    <div class="modal-dialog">

    </div>
</div>