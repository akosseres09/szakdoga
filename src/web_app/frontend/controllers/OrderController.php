<?php

namespace frontend\controllers;

use frontend\components\BaseController;
use Stripe\Invoice;
use Stripe\Stripe;
use yii\filters\AccessControl;
use yii\web\ErrorAction;
use yii\web\Response;

class OrderController extends BaseController
{
    public function behaviors(): array
    {
        return array_merge([
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
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
            ]
       ];
    }

    public function actionIndex(): array
    {
        $user = \Yii::$app->user->identity;
        Stripe::setApiKey(\Yii::$app->stripe->secretKey);
        try {
            $invoices = Invoice::all(['customer' => $user->stripe_cus])->data;
            if (empty($invoices)) {
                $invoices = 'No Items Found';
            }
        } catch (\Exception $e) {
            \Yii::$app->session->setFlash('Error', $e->getMessage());
        }
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'data' => $invoices
        ];
    }

}