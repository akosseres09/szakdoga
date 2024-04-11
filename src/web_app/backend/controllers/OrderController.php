<?php

namespace backend\controllers;

use common\models\search\OrderSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class OrderController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['orders', 'view'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actionOrders(): string
    {
        $orderSearch = new OrderSearch();
        $orders = $orderSearch->search(Yii::$app->request->get());

        return $this->render('orders', [
            'orders' => $orders,
            'search' => $orderSearch
        ]);
    }

    public function actionView(int $userId, int $date)
    {
        return '';
    }
}