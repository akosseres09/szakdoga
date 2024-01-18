<?php

namespace frontend\controllers;

use common\models\BillingInformation;
use common\models\ShippingInformation;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class UserController extends Controller
{
    public function behaviors(): array
    {
       return [
           'access' => [
               'class' => AccessControl::class,
               'only' => ['settings', 'account', 'save-billing', 'save-shipping'],
               'rules' => [
                   [
                       'actions' => ['settings', 'account', 'save-billing', 'save-shipping'],
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
       ];

    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class
            ]
        ];
    }

    public function actionAccount(): Response|string
    {
        $user = \Yii::$app->user->getIdentity();
        $shippingInfo = ShippingInformation::findOne(['user_id' => $user->id]);
        if($shippingInfo === null){
            $shippingInfo = new ShippingInformation();
        }

        $billingInfo = BillingInformation::findOne(['user_id' => $user->id]);
        if($billingInfo === null){
            $billingInfo = new BillingInformation();
        }

        return $this->render('account', [
            'user' => $user,
            'billingInfo' => $billingInfo,
            'shippingInfo' => $shippingInfo
        ]);
    }

    public function actionSettings(): string
    {
        return $this->render('settings');
    }

    public function actionUpdate(): Response|string
    {
        $user = \Yii::$app->user->getIdentity();
        $request = \Yii::$app->request;
        if ($request->isPost && $user->load($request->post())){
            if($user->save()){
                \Yii::$app->session->setFlash('Success', 'Profile updated successfully!');
            }else{
                \Yii::$app->session->setFlash('Error', 'Profile updated failed!');
            }
            return $this->redirect(['/user/account']);
        }

        return $this->renderPartial('update', [
            'user' => $user,
        ]);
    }


    public function actionSaveShipping(): Response
    {
        $user = \Yii::$app->user->getIdentity();
        $shippingInfo = ShippingInformation::findOne(['user_id' => $user->id]);
        if($shippingInfo === null){
            $shippingInfo = new ShippingInformation();
        }

        if($this->request->isPost && $shippingInfo->load(\Yii::$app->request->post())){
            if($shippingInfo->save()){
                \Yii::$app->session->setFlash('ShippingSuccess', 'Shipping Information saved successfully!');
            }else{
                \Yii::$app->session->setFlash('ShippingError', 'Failed to save shipping information!');
            }
        }
        return $this->redirect(['/user/account']);
    }

    public function actionSaveBilling(): Response
    {
        $user = \Yii::$app->user->getIdentity();
        $billingInfo = BillingInformation::findOne(['user_id' => $user->id]);
        if ($billingInfo === null) {
           $billingInfo = new BillingInformation();
        }

        if($this->request->isPost && $billingInfo->load(\Yii::$app->request->post())){
            if($billingInfo->save()){
                \Yii::$app->session->setFlash('BillingSuccess', 'Billing Information saved successfully!');
            }else {
                \Yii::$app->session->setFlash('BillingError', 'Failed to save billing Information!');
            }
        }
        return $this->redirect(['/user/account']);
    }

}