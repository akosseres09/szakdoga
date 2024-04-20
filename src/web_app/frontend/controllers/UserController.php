<?php

namespace frontend\controllers;

use common\models\BillingInformation;
use common\models\ShippingInformation;
use common\models\User;
use frontend\components\BaseController;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\Stripe;
use Throwable;
use Yii;
use yii\data\ArrayDataProvider;
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
               'only' => ['settings', 'account', 'save-billing', 'save-shipping', 'invoices', 'delete'],
               'rules' => [
                   [
                       'actions' => ['settings', 'account', 'save-billing', 'save-shipping', 'invoices', 'delete'],
                       'allow' => true,
                       'roles' => ['@']
                   ]
               ]
           ],
           'verbs' => [
               'class' => VerbFilter::class,
               'actions' => [
                   'update' => ['POST'],
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

    public function actionSettings(): array|string
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'data' => $this->renderPartial('settings')
            ];
        } else {
            return $this->render('settings-full');
        }
    }

    public function actionUpdate(): Response
    {
        $user = Yii::$app->user->identity;
        $request = Yii::$app->request;
        if ($request->isPost) {
            if ($user->load($request->post())){
                if($user->save()){
                    Yii::$app->session->setFlash('Success', 'Profile updated successfully!');
                }else{
                    $fail = '';
                    foreach ($user->getErrors() as $error) {
                        $fail .= '<span>' . $error[0] . '</span><br>';
                    }
                    Yii::$app->session->setFlash('Error', $fail);
                }
            }
        }
        return $this->redirect(['/user/settings']);
    }

    public function actionDelete(): Response
    {
        $id = (int)Yii::$app->request->post('User')['id'];
        if ($id !== Yii::$app->user->id) {
            Yii::$app->session->setFlash('Error', 'You cannot delete other accounts!');
            return $this->redirect(['/user/settings']);
        }

        $user = User::find()->ofId($id)->ofDeleted()->one();
        if (!$user) {
            Yii::$app->session->setFlash('Error', 'User not found!');
            return $this->redirect(['/user/settings']);
        }

        $user->deleted_at = strtotime('now');
        $user->status = User::STATUS_INACTIVE;

        if ($user->save()) {
            var_dump(Yii::$app->cache->delete(User::getCacheKey($id)));
            Yii::$app->session->setFlash('Success', 'User activated successfully!');
            Yii::$app->user->logout();
            return $this->goHome();
        } else {
            Yii::$app->session->setFlash('Error', $user->errors);
        }

        return $this->redirect(['/user/settings']);
    }

    public function actionInvoices(): array|string
    {
        $user = Yii::$app->user->identity;
        try {
            Stripe::setApiKey(Yii::$app->stripe->secretKey);
            $invoices = Invoice::all(['customer' => $user->stripe_cus])->data;
            if (empty($invoices)) {
                $invoices = [];
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('Error', $e->getMessage());
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $invoices,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'data' => $this->renderPartial('/order/invoices', [
                    'invoices' => $dataProvider,
                ])
            ];
        } else {
            return $this->render('/order/invoices-full', [
                'invoices' => $dataProvider
            ]);
        }
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