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

$this->beginContent('@frontend/views/user/account-wrapper.php');

?>

<div class="container rounded bg-white mt-5 mb-5">
    <div id="settings-container" class="row justify-content-evenly">
            <?= $this->render('_account', [
                'user' => $user,
                'billingInfo' => $billingInfo,
                'shippingInfo' => $shippingInfo
            ]) ?>
    </div>
</div>

<?php $this->endContent();
