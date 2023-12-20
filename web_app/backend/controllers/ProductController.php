<?php

namespace backend\controllers;

use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;

class ProductController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['products', 'add'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actionProducts(): string
    {
        $products = new ActiveDataProvider([
            'query' => Product::find(),
            'sort' => ['defaultOrder' => [
                'is_activated' => SORT_ASC,
            ]],
            'pagination' => [
                'pageSize' => 15
            ]
        ]);
        return $this->render('products', [
            'products' => $products
        ]);
    }

    public function actionAdd(): Response|string
    {
        $request = \Yii::$app->request;
        $product = new Product();
        if ($request->isPost && $product->load($request->post())) {
            if ($product->save()) {
                \Yii::$app->session->setFlash('success', 'Successfully Created a new Product!');
            } else {
                \Yii::$app->session->setFlash('error', 'Failed to create this product!');
            }
            return $this->redirect(['/product/products']);
        }

        return $this->render('add', [
            'product' => $product
        ]);
    }
}