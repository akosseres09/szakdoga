<?php

namespace frontend\controllers;

use common\models\BillingInformation;
use common\models\Cart;
use common\models\Order;
use common\models\ShippingInformation;
use frontend\components\BaseController;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

class PaymentController extends BaseController
{
    public function behaviors(): array
    {
        return array_merge([
            'rules' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'payment-info',
                            'pay',
                            'payment-fail',
                            'payment-cancel',
                            'payment-success'
                        ],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'pay' => ['POST'],
                ]
            ]
        ],
        parent::behaviors());
    }

    public function actionPaymentInfo(): Response|string
    {
        $userId = Yii::$app->user->id;
        $billingInfo = BillingInformation::find()->ofUser($userId)->one();
        $shippingInfo = ShippingInformation::find()->ofUser($userId)->one();

        $query = Cart::find()->ofUser($userId)->with(['product']);

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
            Yii::$app->session->setFlash('emptyCart', 'Your Cart Is Empty!');
            return $this->redirect('/cart');
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

            if (!$billing) {
                $billing = new BillingInformation();
            }

            if (!$shipping) {
                $shipping = new ShippingInformation();
            }

            $cart = Cart::find()->ofUser($id)->with(['product'])->all();
            $lineItems = [];
            foreach ($cart as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'product_data' => [
                            'name' => $item->product->brand_name . ' ' . $item->product->name
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
                Yii::error('Failed to initialize checkout session to pay: ' . $e->getMessage());
                $transaction->rollBack();
                Yii::$app->session->setFlash('Something Went Wrong With Your Payment! Please Try Again Later!');
                return $this->redirect('/payment');
            }
        }
    }

    public function actionPaymentCancel($session_id): string
    {
        $session = null;
        try {
            Stripe::setApiKey(Yii::$app->stripe->secretKey);
            $session = Session::retrieve($session_id);
        } catch (ApiErrorException $e) {
            Yii::error('Failed to retrieve session at payment-cancel at:' . Yii::$app->formatter->asDate(strtotime('now')) . ' ' . $e->getMessage(), __METHOD__);
        }
        return $this->render('/payment/payment-fail', [
            'session' => $session
        ]);
    }

    public function actionPaymentFail(): string
    {
        return $this->render('/payment/payment-fail');
    }

    public function actionPaymentSuccess($session_id): string|Response
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Stripe::setApiKey(Yii::$app->stripe->secretKey);
            $session = Session::retrieve($session_id);

            $userId = Yii::$app->user->id;
            $cartItems = Cart::find()->ofUser($userId)->with('product')->all();
            $items = $cartItems;

            if ($session->status === 'complete' && $session->payment_status === 'paid') {
                foreach ($items as $index => $item) {

                    $order = new Order();
                    $order->product_id = $item->product_id;
                    $order->user_id = $item->user_id;
                    $order->quantity = $item->quantity;
                    $order->size = $item->size;

                    if ($order->save()) {
                        $product = $item->product;
                        $product->number_of_stocks -= $item->quantity;
                        if ($product->save()) {
                            $cartItems[$index]->delete();
                        }
                    }
                }
                $transaction->commit();
                return $this->render('/payment/payment-success');
            } else {
                return $this->render('/payment/payment-fail');
            }

        } catch (\Exception|Throwable $e) {
            Yii::error('Error at payment-success at: ' . Yii::$app->formatter->asDate(strtotime('now')) . ' with: ' . $e->getMessage(), __METHOD__);
            $transaction->rollBack();
            return $this->redirect(['payment-fail']);
        }
    }
}