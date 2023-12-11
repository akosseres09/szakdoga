<?php

namespace backend\controllers;

use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class UserController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['users'],
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
               'class' => \yii\web\ErrorAction::class
           ]
       ];
    }

    public function actionUsers(): string
    {
        $users = new ActiveDataProvider([
            'query' => User::find()->all()
        ]);
        return $this->render('users', [
            'users' => $users
        ]);
    }
}