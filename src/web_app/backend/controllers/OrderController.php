<?php

namespace backend\controllers;

use common\models\Order;
use common\models\search\OrderSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

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

    public function actionView(int $user, int $date): string|Response
    {
        $query = Order::find()->ofUser($user)->ofDate($date)->with('product');

        $orders = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ]
        ]);

        if ($orders->totalCount === 0) {
            Yii::$app->session->setFlash('Error', 'No Orders with the given id or date!');
            return $this->redirect('/orders');
        }

        return $this->render('view', [
            'orders' => $orders,
        ]);
    }
}