<?php

use yii\log\FileTarget;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'app' => [
            'class' => 'yii\web\Application',
            'name' => 'Sportify'
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'maxFileSize' => 1024,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'landing/main' => '/',
                'shop/view/<id>' => 'shop/view',
                'shop/add-to-wishlist/<id>' => 'shop/add-to-wishlist',
                'shop/remove-from-wishlist/<id>' => 'shop/remove-from-wishlist',
                'shop/add-rating/<id>' => 'shop/add-rating',
                'shop/get-rating/<id>' => 'shop/get-rating',
                'cart/delete-from-cart/<id>' => 'cart/delete-from-cart',
                'cart/move-to-wishlist/<id>' => 'cart/move-to-wishlist',
                'wishlist/delete-from-wishlist/<id>' => 'wishlist/delete-from-wishlist',
                'wishlist' => 'wishlist/index',
                'order' => 'order/index',
                'shop' => 'shop/products',
                'cart' => 'cart/cart',
                'payment' => 'cart/payment-info'
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true
        ]

    ],
    'params' => $params,
];
