<?php

use yii\log\EmailTarget;
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
//                [
//                    'class' => EmailTarget::class,
//                    'levels' => ['error', 'warning'],
//                    'exportInterval' => 100,
//                    'message' => [
//                        'from' => 'errors@sportify.com',
//                        'to' => 'admin@sportify.com',
//                        'subject' => 'Logs'
//                    ]
//                ],
                [
                    'class' => FileTarget::class,
                    'levels' => ['info'],
                    'maxFileSize' => 1024
                ]
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
                '<controller>/<action>/<id>' => '<controller>/<action>',
                'wishlist' => 'wishlist/index',
                'order' => 'order/index',
                'shop' => 'shop/products',
                'cart' => 'cart/cart',
                'payment' => 'payment/payment-info',
                'payment-cancel' => 'payment/payment-cancel',
                'payment-success' => 'payment/payment-success',
                'invoices' => 'user/invoices',
                'account' => 'user/account',
                'settings' => 'user/settings'
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true
        ]

    ],
    'params' => $params,
];
