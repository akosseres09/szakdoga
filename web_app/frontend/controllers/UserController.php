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
               'only' => ['settings', 'account', 'save-user', 'save-billing', 'save-shipping'],
               'rules' => [
                   [
                       'actions' => ['settings', 'account', 'save-billing', 'save-user', 'save-shipping'],
                       'allow' => true,
                       'roles' => ['@']
                   ]
               ]
           ],
           'verbs' => [
               'class' => VerbFilter::class,
               'actions' => [
                   'save-user' => ['post'],
                   'save-shipping' => ['post'],
                   'save-billing' => ['post']
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

    public function actionAccount($user_id): Response|string
    {
        if((int)$user_id !== \Yii::$app->user->id){
            return $this->redirect(['/']);
        }
        $user = User::findOne($user_id);
        $shippingInfo = new ShippingInformation();
        $billingInfo = new BillingInformation();
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

    public function actionUpdate($user_id): Response|string
    {
        if((int)$user_id !== \Yii::$app->user->id){
            return $this->redirect(['/user/account/' . \Yii::$app->user->id]);
        }
        $user = User::findOne($user_id);
        return $this->render('update', [
            'user' => $user,
        ]);
    }

    public function actionSaveUser($user_id): Response|string
    {
        if((int)$user_id !== \Yii::$app->user->id){
            return $this->redirect(['/user/account/' . $user_id]);
        }
        $user = User::findOne($user_id);
        if($this->request->isPost && $user->load(\Yii::$app->request->post())){
            if($user->save()){
                \Yii::$app->session->setFlash('UpdateSuccess', 'Profile updated successfully!');
            }else{
                \Yii::$app->session->setFlash('UpdateError', 'Profile updated failed!');
            }
            return $this->redirect(['user/account/'.$user->id]);
        }
        return $this->render('update', [
            'user' => $user
        ]);
    }

    public function actionSaveShipping($user_id): Response|string
    {
        if((int)$user_id !== \Yii::$app->user->id){
            return $this->redirect(['/user/account/' . $user_id]);
        }
        $user = User::findOne($user_id);
        $shippingInfo = new ShippingInformation();
        if($this->request->isPost && $shippingInfo->load(\Yii::$app->request->post())){
            if($shippingInfo->save()){
                \Yii::$app->session->setFlash('ShippingSuccess', 'Shipping Information saved successfully!');
            }else{
                \Yii::$app->session->setFlash('ShippingError', 'Failed to save shipping information!');
            }
            return $this->redirect(['/user/account']);
        }
        return $this->render('update', [
            'user' => $user
        ]);
    }

    public function actionSaveBilling($user_id){
        if((int)$user_id !== \Yii::$app->user->id){
            return $this->redirect(['/user/account/' . $user_id]);
        }
    }

}