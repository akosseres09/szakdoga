<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\Product;
use yii\captcha\CaptchaAction;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
                'only' => ['products', 'view', 'add-to-cart'],
                'rules' => [
                    [
                        'actions' => ['products', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@']
                    ],
                    [
                        'actions' => ['add-to-cart', 'delete-from-cart'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add-to-cart' => ['POST'],
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
            'query' => Product::find()->ofActive(),
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
        $cart = new Cart();

        if ($product === null) {
           return $this->redirect('/shop/products');
        }

        return $this->render('view', [
            'product' => $product,
            'cart' => $cart
        ]);
    }

    public function actionAddToCart(): Response|string
    {
        $request = \Yii::$app->request;
        $id = $request->post('product_id');
        $product = Product::findOne($id);
        if ($product === null) {
            return $this->redirect('/shop/products');
        }

        $cart = new Cart();

        if ($request->isPost && $cart->load($request->post())) {
            $cart->user_id = \Yii::$app->user->id;
            $cart->product_id = $id;
            $cart->price = $product->price;
            if($cart->save()){
                return $this->renderPartial('_cartModal',[
                    'product' => $product,
                    'success' => true
                ]);
            } else {
                return $this->renderPartial('_cartModal',[
                    'product' => $product,
                    'success' => false
                ]);
            }
        }
        return $this->redirect('/shop/view/'.$id);
    }

}