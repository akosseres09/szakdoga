<?php

namespace frontend\controllers;

use common\models\BillingInformation;
use common\models\ShippingInformation;
use frontend\components\BaseController;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\Stripe;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends BaseController
{
    public function behaviors(): array
    {
       return array_merge([
           'access' => [
               'class' => AccessControl::class,
               'only' => ['settings', 'account', 'save-billing', 'save-shipping', 'get-invoices'],
               'rules' => [
                   [
                       'actions' => ['settings', 'account', 'save-billing', 'save-shipping', 'get-invoices'],
                       'allow' => true,
                       'roles' => ['@']
                   ]
               ]
           ],
           'verbs' => [
               'class' => VerbFilter::class,
               'actions' => [
                   'update' => ['GET', 'POST'],
                   'save-shipping' => ['POST'],
                   'save-billing' => ['POST']
               ],
           ],
       ], parent::behaviors());

    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class
            ]
        ];
    }

    /**
     * @throws Throwable
     * @throws NotFoundHttpException
     */
    public function actionAccount(): array|string
    {
        $user = Yii::$app->user->getIdentity();
        $shippingInfo = ShippingInformation::findOne(['user_id' => $user->id]);
        if($shippingInfo === null){
            $shippingInfo = new ShippingInformation();
        }

        $billingInfo = BillingInformation::findOne(['user_id' => $user->id]);
        if($billingInfo === null){
            $billingInfo = new BillingInformation();
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'data' => $this->renderPartial('_account', [
                    'user' => $user,
                    'billingInfo' => $billingInfo,
                    'shippingInfo' => $shippingInfo
                ])
            ];
        }

        return $this->render('account', [
            'user' => $user,
            'billingInfo' => $billingInfo,
            'shippingInfo' => $shippingInfo
        ]);
    }

    public function actionSettings(): array
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'data' => $this->renderPartial('settings')
            ];
        } else {
            throw new NotFoundHttpException('You can not access this page with this request: ' . Yii::$app->request->method);
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetInvoices(): array
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $user = Yii::$app->user->identity;

            try {
                Stripe::setApiKey(Yii::$app->stripe->secretKey);
                $invoices = Invoice::all(['customer' => $user->stripe_cus])->data;
                if (empty($invoices)) {
                    $invoices = 'No Items Found';
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('Error', $e->getMessage());
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'data' => $invoices
            ];

        } else {
            throw new NotFoundHttpException('You can not access this page with this request: ' . Yii::$app->request->method);
        }

    }

    public function actionUpdate(): Response|string
    {
        $user = Yii::$app->user->getIdentity();
        $request = Yii::$app->request;
        if ($request->isPost && $user->load($request->post())){
            if($user->save()){
                Yii::$app->session->setFlash('Success', 'Profile updated successfully!');
            }else{
                Yii::$app->session->setFlash('Error', 'Profile updated failed!');
            }
            return $this->redirect(['/user/account']);
        }

        return $this->renderPartial('update', [
            'user' => $user,
        ]);
    }

    public function actionSaveShipping(): Response
    {
        $user = Yii::$app->user->getIdentity();
        $shippingInfo = ShippingInformation::findOne(['user_id' => $user->id]);

        if($shippingInfo === null){
            $shippingInfo = new ShippingInformation();
        }

        if($this->request->isPost && $shippingInfo->load(Yii::$app->request->post())){
            if($shippingInfo->save()){
                Yii::$app->session->setFlash('ShippingSuccess', 'Shipping Information saved successfully!');
            }else{
                Yii::$app->session->setFlash('ShippingError', 'Failed to save shipping information!');
            }
        }
        return $this->redirect(['/user/account']);
    }

    public function actionSaveBilling(): Response
    {
        $user = Yii::$app->user->getIdentity();
        $billingInfo = BillingInformation::findOne(['user_id' => $user->id]);

        if ($billingInfo === null) {
           $billingInfo = new BillingInformation();
        }

        if($this->request->isPost && $billingInfo->load(Yii::$app->request->post())){
            if($billingInfo->save()){
                try {
                    Stripe::setApiKey(Yii::$app->stripe->secretKey);
                    if ($user->stripe_cus) {
                        $customer = Customer::retrieve($user->stripe_cus);
                        Customer::update(
                            $customer->id,
                            [
                                'address' => [
                                    'city' => $billingInfo->city,
                                    'country' => $billingInfo->country,
                                    'state' => $billingInfo->state,
                                    'postal_code' => $billingInfo->postcode,
                                    'line1' => $billingInfo->street
                                ]
                            ]
                        );
                    }
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('BillingError', $e->getMessage());
                }
                Yii::$app->session->setFlash('BillingSuccess', 'Billing Information saved successfully!');
            }else {
                Yii::$app->session->setFlash('BillingError', 'Failed to save billing Information!');
            }
        }
        return $this->redirect(['/user/account']);
    }

}