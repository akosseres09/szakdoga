<?php

namespace frontend\controllers;

use common\models\Cart;
use Yii;
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
                'only' => ['cart', 'delete-from-cart'],
                'rules' => [
                    [
                        'actions' => ['cart', 'delete-from-cart'],
                        'allow' => true,
                        'roles' => ['?', '@']
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete-from-cart' => ['POST']
                ]
            ]
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
        $user_id = Yii::$app->user->id;
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

    public function actionDeleteFromCart(): array
    {
        $id = Yii::$app->request->post('id');
        $cart = Cart::findOne($id);
        $success = false;

        if ($cart === null) {
            return [
                'success' => false
            ];
        }

        if (Yii::$app->request->isPost) {
            try {
                $cart->delete();
                $success = true;
            }catch (\Throwable $t) {
                Yii::$app->session->setFlash('Error', 'An error occurred while deleting item from cart!');
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => $success
        ];
    }
}