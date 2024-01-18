<?php

namespace frontend\controllers;

use common\models\Cart;
use yii\captcha\CaptchaAction;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class CartController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['cart','delete-from-cart'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function actions()
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

    public function actionCart(): string
    {
        $user_id = \Yii::$app->user->id;
        $query = Cart::find()->ofUser($user_id);
        $count = $query->sum('quantity');

        $cartItems = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ]
        ]);

        $total = 0;
        foreach ($cartItems->getModels() as $item){
            $total += $item->quantity * $item->price;
        }

        return $this->render('cart', [
            'cartItems' => $cartItems,
            'q' => $count,
            'total' => $total
        ]);
    }


    public function actionDeleteFromCart($id): Response|string
    {
        $cart = Cart::findOne($id);

        if ($cart === null) {
            return $this->redirect('/cart/cart');
        }

       if (\Yii::$app->request->isPost) {
           try {
               $cart->delete();
           }catch (\Throwable $t) {
               \Yii::$app->session->setFlash('Error', 'An error occurred while deleting item from cart!');
           }

           return $this->redirect('/cart/cart');
       }else {
           return $this->renderPartial('_deleteModal', [
               'item' => $cart
           ]);
       }

    }
}