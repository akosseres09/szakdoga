<?php

namespace backend\controllers;

use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
                        'actions' => ['users','delete', 'edit'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'edit' => ['POST'],
                    'delete' => ['POST']
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
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 15
            ]
        ]);
        return $this->render('users', [
            'users' => $users
        ]);
    }

    public function actionEdit($id): \yii\web\Response
    {
        return $this->redirect('/user/users');
    }

    public function actionDelete($id): \yii\web\Response
    {
        return $this->redirect('/user/users');
    }
}