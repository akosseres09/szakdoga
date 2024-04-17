<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\Wishlist;
use frontend\components\BaseController;
use Throwable;
use Yii;
use yii\captcha\CaptchaAction;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends BaseController
{
    public function behaviors(): array
    {
        return array_merge([
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'cart',
                            'delete-from-cart',
                            'move-to-wishlist'
                        ],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'pay' => ['POST'],
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
        $query = Cart::find()->ofUser($user_id)->with(['product']);

        $cartItems = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0
            ],
            'sort' => [
                'defaultOrder' => [
                    'added_at' => SORT_DESC
                ]
            ]
        ]);

        $total = 0;
        foreach ($cartItems->getModels() as $item){
            $total += $item->quantity * $item->price;
        }

        return $this->render('cart', [
            'cartItems' => $cartItems,
            'totalCount' => $cartItems->totalCount,
            'total' => $total
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDeleteFromCart($id): array
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $cart = Cart::findOne($id);
            $success = false;

            if ($cart === null) {
                return [
                    'success' => false
                ];
            }

            try {
                if ($cart->delete()) {
                    $success = true;
                }
            } catch (Throwable) {
                Yii::$app->session->setFlash('Error', 'An error occurred while deleting item from cart!');
            }
            return [
                'success' => $success
            ];
        } else {
            throw new NotFoundHttpException('You can not access this page with this request: '. Yii::$app->request->method);
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionMoveToWishlist($id): array
    {
        if (Yii::$app->request->isAjax) {
            $item = Cart::findOne($id);
            $transaction = Yii::$app->db->beginTransaction();
            $wishlist = new Wishlist();

            $data = [];

            try {
                $wishlist->product_id = $item->product_id;
                $wishlist->user_id = $item->user_id;

                if ($wishlist->save()) {
                    if ($item->delete()) {
                        $transaction->commit();
                        $data = [
                            'success' => true
                        ];
                    } else {
                        $transaction->rollBack();
                        $data = [
                            'success' => false,
                            'errors' => 'Failed to Add Product to Your Wishlist!'
                        ];
                    }
                } else {
                    $transaction->rollBack();
                    $data = [
                        'success' => false,
                        'errors' => $wishlist->getErrors()
                    ];
                }
            } catch (StaleObjectException|Throwable $e) {
                $transaction->rollBack();
                $data = [
                    'success' => false,
                    'errors' => $e->getMessage()
                ];
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $data;
        } else {
            throw new NotFoundHttpException('You can not access this page with this request: '. Yii::$app->request->method);
        }
    }
}