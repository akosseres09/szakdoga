<?php

namespace frontend\controllers;

use common\models\Order;
use frontend\components\BaseController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\ErrorAction;
use yii\web\Response;

class OrderController extends BaseController
{
    public function behaviors(): array
    {
        return array_merge([
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'items'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ], parent::behaviors());
    }

    public function actions(): array
    {
       return [
           'error' => [
                'class' => ErrorAction::class,
                'layout' => 'mainWithoutHeaderAndFooter'
            ]
       ];
    }

    public function actionIndex(): array|string
    {
        $query = (new Query())->select([
            'order.created_at',
        ])->distinct()
            ->from('{{%order}}')
            ->where(['order.user_id' => Yii::$app->user->id])
            ->orderBy('order.created_at')
            ->groupBy('order.created_at');

        $orders = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'data' => $this->renderAjax('orders', [
                    'orders' => $orders
                ])
            ];

        } else {
            return $this->render('orders-full', [
               'orders' => $orders
            ]);
        }
    }

    public function actionItems($date): string|Response
    {
        $user = Yii::$app->user;
        $order = Order::find()->ofDate($date)->ofUser($user->id)->with(['product'])->all();


        if (empty($order)) {
            return $this->redirect('/user/account?tab=orders');
        }

        $orders = new ArrayDataProvider([
            'allModels' => $order
        ]);

        return $this->render('view', [
            'orders' => $orders
        ]);
    }

}