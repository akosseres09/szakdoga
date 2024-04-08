<?php

namespace frontend\controllers;

use frontend\components\BaseController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\ErrorAction;

class OrderController extends BaseController
{
    public function behaviors(): array
    {
        return array_merge([
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
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

    public function actionIndex()
    {
//        if (Yii::$app->request->isAjax) {
            $query = (new Query())->select(['order.created_at', 'order.user_id' , 'GROUP_CONCAT(brand.name, " " ,product.name) AS name'])
                ->from('{{%order}}')->leftJoin('{{%product}}', 'order.product_id = product.id')
                ->where(['order.user_id' => Yii::$app->user->id])
                ->leftJoin('{{%brand}}', 'product.brand_id = brand.id')->orderBy('order.created_at')
                ->groupBy('order.created_at');

            $orders = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 0
                ]
            ]);
//            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->render('orders', [
                'orders' => $orders
            ]);
            return [
                'data' => $this->renderAjax('orders', [
                    'orders' => $orders
                ])
            ];

//        } else {
//            throw new NotFoundHttpException('You can not access this page with this request: ' . Yii::$app->request->method);
//        }
    }

}