<?php

namespace frontend\controllers;

use common\models\BillingInformation;
use common\models\Cart;
use common\models\Order;
use common\models\ShippingInformation;
use common\models\Wishlist;
use frontend\components\BaseController;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
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
                        'actions' => ['cart', 'delete-from-cart', 'payment-info', 'move-to-wishlist', 'pay', 'payment-cancel', 'payment-success'],
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
        $query = Cart::find()->ofUser($user_id)->with(['product', 'product.type', 'product.brand']);

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
            }catch (Throwable) {
                Yii::$app->session->setFlash('Error', 'An error occurred while deleting item from cart!');
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'success' => $success
            ];
        } else {
            throw new NotFoundHttpException('You can not access this page with this request: '. Yii::$app->request->method);
        }
    }

    public function actionPaymentInfo(): Response|string
    {
        $userId = Yii::$app->user->id;
        $billingInfo = BillingInformation::find()->ofUser($userId)->one();
        $shippingInfo = ShippingInformation::find()->ofUser($userId)->one();

        $query = Cart::find()->ofUser($userId)->with(['product', 'product.brand']);

        $products = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0
            ]
        ]);

        $total = 0;
        foreach ($products->getModels() as $product) {
            $total += ($product->quantity * $product->price);
        }

        if (!$billingInfo) {
            $billingInfo = new BillingInformation();
        }

        if (!$shippingInfo) {
            $shippingInfo = new ShippingInformation();
        }

        $cartItems = Cart::find()->ofUser($userId)->all();

        if (empty($cartItems)) {
            Yii::$app->session->setFlash('emptyCart');
            return $this->redirect('/cart/cart');
        }

        return $this->render('payment-info', [
            'products' => $products,
            'billing' => $billingInfo,
            'shipping' => $shippingInfo,
            'total' => $total,
        ]);
    }

    public function actionPay()
    {
        $user = Yii::$app->user->identity;
        $id = $user->id;
        $request = Yii::$app->request;
        $transaction = Yii::$app->db->beginTransaction();

        if ($request->isPost) {
            $billing = BillingInformation::find()->ofUser($id)->one();
            $shipping = ShippingInformation::find()->ofUser($id)->one();
            $cart = Cart::find()->ofUser($id)->with(['product', 'product.brand'])->all();
            $lineItems = [];
            foreach ($cart as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'product_data' => [
                            'name' => $item->product->brand->name . ' ' . $item->product->name
                        ],
                        'currency' => 'usd',
                        'unit_amount' => $item->product->price * 100
                    ],
                    'quantity' => $item->quantity
                ];
            }
            try {
                Stripe::setApiKey(Yii::$app->stripe->secretKey);
                $customer = Customer::retrieve($user->stripe_cus);
                if ($billing->load($request->post()) && $billing->validate()) {
                    Customer::update($customer->id, [
                        'address' => [
                            'city' => $billing->city,
                            'country' => $billing->country,
                            'state' => $billing->state,
                            'postal_code' => $billing->postcode,
                            'line1' => $billing->street
                        ]
                    ]);
                    $billing->save();
                }

                if ($shipping->load($request->post()) && $shipping->validate()) {
                    $shipping->save();
                }

                $transaction->commit();
                $checkout = Session::create([
                    'customer' => $user->stripe_cus,
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => Yii::$app->params['hostUrl'] . '/payment-success?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => Yii::$app->params['hostUrl'] . '/payment-cancel?session_id={CHECKOUT_SESSION_ID}',
                    'invoice_creation' => [
                        'enabled' => true
                    ]
                ]);
                $this->redirect($checkout->url);

            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('Something Went Wrong With Your Payment! Please Try Again Later!');
                return $this->redirect('/payment');
            }
        }
    }

    public function actionPaymentCancel($session_id): Response|string
    {
        return $this->render('/payment/payment-fail');
    }

    public function actionPaymentSuccess($session_id): string
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Stripe::setApiKey(Yii::$app->stripe->secretKey);
            $session = Session::retrieve($session_id);

            $userId = Yii::$app->user->id;
            $cartItems = Cart::find()->ofUser($userId)->all();
            $items = $cartItems;

            if ($session->status === 'complete' && $session->payment_status === 'paid') {
                foreach ($items as $index => $item) {

                    $order = new Order();
                    $order->product_id = $item->product_id;
                    $order->user_id = $item->user_id;
                    $order->quantity = $item->quantity;
                    $order->size = $item->size;

                    if ($order->save()) {
                        $cartItems[$index]->delete();
                    }
                }
                $transaction->commit();
                return $this->render('/payment/payment-success');
            } else {
                return $this->render('/payment/payment-fail');
            }

        } catch (\Exception|Throwable) {
            $transaction->rollBack();
            return $this->render('/payment/payment-fail');
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