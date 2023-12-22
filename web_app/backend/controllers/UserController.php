<?php

namespace backend\controllers;

use common\models\User;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['users','delete', 'edit', 'change-role'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'upgrade' => ['POST'],
                    'demote' => ['POST']
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

    public function actionEdit($id): Response | string
    {
        $user = User::findOne($id);
        $request = \Yii::$app->request;

        if ($user === null) {
            return $this->redirect('/user/users');
        }

        if ($request->isPost && $user->load($request->post())) {
            if ($user->save()) {
               \Yii::$app->session->setFlash('Success', 'Successfully Edited User!');
            } else {
                \Yii::$app->session->setFlash('Error', 'Failed To Edit User!');
            }

            return $this->redirect('/user/users');
        }

        return $this->render('edit', ['user' => $user]);
    }

    public function actionDelete($id): Response
    {
        $user = User::findOne($id);

        if ($user === null) {
            return $this->redirect('/user/users');
        }

        try {
            if ($user->delete()) {
                \Yii::$app->session->setFlash('Success', 'User successfully deleted!');
            } else {
                \Yii::$app->session->setFlash('Error', 'Something went wrong. User could not be deleted!');
            }

        }catch (\Throwable $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect('/user/users');
    }

    public function actionChangeRole($id): Response
    {
        $user = User::findOne($id);

        if ($user === null) {
           return $this->redirect('/user/edit/'.$id);
        }

        $user->is_admin === 0 ? $user->is_admin = 1 : $user->is_admin = 0;
        if ($user->save()) {
            \Yii::$app->session->setFlash('Success', 'Changed User Role to:' . $user->getRole() . '!');
        } else {
            \Yii::$app->session->setFlash('Error', 'Failed to Change User Role!');
        }

        return $this->redirect('/user/users');
    }
}