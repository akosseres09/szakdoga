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

<?php
foreach (Yii::$app->session->getAllFlashes() as $key => $message):
    if(str_contains($key, 'Success')): ?>
        <div class="alert alert-success  my-3">
            <?= $message ?>
        </div>
    <?php elseif (str_contains($key, 'Error')): ?>
        <div class="alert alert-danger my-3">
            <?= $message ?>
        </div>
    <?php endif;
endforeach; ?>
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