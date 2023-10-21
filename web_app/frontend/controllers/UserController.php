<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;

class UserController extends Controller
{
    public function behaviors()
    {
       return [
           'access' => [
               'class' => AccessControl::class,
               'only' => ['settings', 'account'],
               'rules' => [
                   [
                       'actions' => ['settings', 'account'],
                       'allow' => true,
                       'roles' => ['@']
                   ]
               ]
           ]
       ];

    }

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class
            ]
        ];
    }

    public function actionAccount(){
        $this->render('account');
    }

    public function actionSettings(){
        $this->render('settings');
    }
}