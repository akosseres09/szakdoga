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
use frontend\assets\AccountAsset;
use yii\helpers\Url;
use yii\web\View;

AccountAsset::register($this);
$this->title = 'Your Account';
$tab = Yii::$app->request->get('tab');
$tabs = [
    'account' => [
        'link' => Url::to(['/user/account']),
        'site' => 'account',
        'active' => 'account-icon active-icon icon-xs',
        'passive' => 'account-icon passive-icon icon-xs'
    ],
    'orders' => [
        'link' => Url::to(['/order']),
        'site' => 'orders'
    ],
    'wishlist' => [
        'link' => Url::to(['/wishlist']),
        'site' => 'wishlist'
    ],
    'settings' => [
        'link' =>  Url::to(['/user/settings']),
        'site' => 'settings',
        'active' => 'settings-icon active-icon icon-xs',
        'passive' => 'settings-icon passive-icon icon-xs'
    ]
];

$tab = $tabs[$tab]['site'] ?? 'account';
$link = $tabs[$tab]['link'];
$this->registerJs(<<<JS
    getAccountPage('$link');
JS
);
?>

<?=
$this->render('/site/common/_alert'); ?>

<ul class="user-profile-tabs">
    <?php foreach ($tabs as $site) {
        $active = $site['site'] === $tab;
        ?>
        <li class="d-flex justify-content-center align-items-center">
            <span class="user-link <?= $active ? 'active' : '' ?>" data-href="<?= $site['link'] ?>">
                <?php if($site['active'] && $site['passive']) { ?>
                    <div class="<?= $active ? $site['active'] : $site['passive'] ?>"></div>
                <?php } ?>
                <?= ucfirst($site['site']) ?>
            </span>
        </li>
    <?php } ?>
</ul>

<div class="container rounded bg-white mt-5 mb-5">
    <div id="settings-container" class="row justify-content-evenly">
        <?php if ($tab === 'account') { ?>
            <?= $this->render('_account', [
                'user' => $user,
                'billingInfo' => $billingInfo,
                'shippingInfo' => $shippingInfo
            ]) ?>
        <?php } ?>
    </div>
</div>
