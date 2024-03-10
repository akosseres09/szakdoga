<?php

namespace frontend\controllers;

use frontend\components\BaseController;
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
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'data' => 'aaa'
        ];
    }

}