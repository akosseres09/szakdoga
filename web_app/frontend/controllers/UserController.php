<?php

namespace frontend\controllers;

use common\models\User;
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

    public function actionAccount(): string
    {
        $user = User::findOne(\Yii::$app->user->id);
        return $this->render('account', [
            'user' => $user
        ]);
    }

    public function actionSettings(): string
    {
        return $this->render('settings');
    }

    public function actionUpdate($user_id){
        if((int)$user_id !== \Yii::$app->user->id){
            return $this->redirect(['/user/account']);
        }
        $user = User::findOne($user_id);
        return $this->render('update', [
            'user' => $user
        ]);
    }
}