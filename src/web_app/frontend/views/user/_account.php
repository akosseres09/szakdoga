<?php
/**
 * @var User $user
 * @var BillingInformation $billingInfo
 * @var ShippingInformation $shippingInfo
 */

use common\models\BillingInformation;
use common\models\ShippingInformation;
use common\models\User;

?>

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
