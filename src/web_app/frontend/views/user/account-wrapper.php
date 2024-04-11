<?php
/**
 * @var View $this
 * @var string $content
 */

use common\widgets\Navigation;
use frontend\assets\AccountAsset;
use frontend\assets\WishlistAsset;
use yii\helpers\Url;
use yii\web\View;

AccountAsset::register($this);
WishlistAsset::register($this);

$this->title = 'Your Account';
$tab = Yii::$app->request->get('tab');
$tabs = [
    'account' => [
        'link' => Url::to(['/user/account']),
        'site' => 'account',
        'active' => 'account-icon active-icon icon-xs',
        'passive' => 'account-icon passive-icon icon-xs'
    ],
    'invoices' => [
        'link' => Url::to(['/user/get-invoices']),
        'site' => 'invoices'
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

echo Navigation::widget([
    'tabs' => $tabs,
    'tab' => $tab
]);

echo $content ?>

