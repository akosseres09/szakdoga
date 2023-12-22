<?php

namespace frontend\controllers;

use common\models\Product;
use yii\captcha\CaptchaAction;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class ShopController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['products'],
                'rules' => [
                    [
                        'actions' => ['products'],
                        'allow' => true,
                        'roles' => ['?', '@']
                    ]
                ]
            ]
        ];
    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'layout' => 'mainWithoutHeaderAndFooter'
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

    public function actionProducts($pageSize = 20): string
    {
        $this->layout = 'shop';
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);


        return $this->render('products',[
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id): Response|string
    {
        $product = Product::findOne($id);

        if ($product === null) {
           return $this->redirect('/shop/products');
        }

        return $this->render('view', [
            'product' => $product
        ]);
    }
}