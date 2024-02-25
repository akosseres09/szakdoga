<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class OrderController extends Controller
{
    public function behaviors(): array
    {
        return [
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
        ];
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