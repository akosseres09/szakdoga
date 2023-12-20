<?php

namespace backend\controllers;

use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\rest\Controller;

class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['products'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actionProducts()
    {
        $products = new ActiveDataProvider([
           'query' => Product::find(),
            'pagination' => [
                'pageSize' => 15
            ]
        ]);
        return $this->render('products', [
            'products' => $products
        ]);
    }
}