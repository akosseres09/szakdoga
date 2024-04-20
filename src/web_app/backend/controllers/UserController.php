<?php

namespace backend\controllers;

use common\models\search\UserSearch;
use common\models\User;
use frontend\components\BaseController;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

class UserController extends BaseController
{
    public function behaviors(): array
    {
        return array_merge([
            'access' => [
                'class' => AccessControl::class,
                'only' => ['users', 'delete', 'edit', 'change-role', 'undelete'],
                'rules' => [
                    [
                        'actions' => ['users', 'delete', 'edit', 'change-role', 'undelete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'undelete' => ['POST'],
                ]
            ]
        ], parent::behaviors());
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
        $userSearch = new UserSearch();
        $users = $userSearch->search(Yii::$app->request->get());
        return $this->render('users', [
            'users' => $users,
            'search' => $userSearch
        ]);
    }

    public function actionEdit($id): Response | string
    {
        $user = User::findOne($id);
        $request = Yii::$app->request;

        if ($user === null) {
            return $this->redirect('/user/users');
        }

        if ($request->isPost && $user->load($request->post())) {
            if ($user->save()) {
               Yii::$app->session->setFlash('Success', 'Successfully Edited User!');
            } else {
                $errors = implode('', $user->getErrors());
                Yii::$app->session->setFlash('Error', 'Failed To Edit User!');
                Yii::warning('Failed To Edit User! ' . $errors, __METHOD__);
            }
            return $this->redirect('/user/users');
        }
        return $this->renderPartial('edit', ['user' => $user]);
    }

    public function actionDelete(): Response
    {
        $id = Yii::$app->request->post('id');
        $user = User::findOne($id);

        if ($user === null) {
            return $this->redirect('/user/users');
        }

        if ($user->deleted_at !== null) {
            return $this->redirect('/user/users');
        }

        $user->deleted_at = strtotime('now');
        if ($user->save()) {
            Yii::$app->session->setFlash('Success', 'Successfully Deleted User!');
        } else {
            $errors = implode('', $user->getErrors());
            Yii::$app->session->setFlash('Error', $errors);
        }

        return $this->redirect('/user/users');
    }

    public function actionUndelete(int $id): Response
    {
        $user = User::find()->ofId($id)->one();
        if (!$user) {
            return $this->redirect('/user/users');
        }

        $user->deleted_at = null;
        $user->status = User::STATUS_ACTIVE;
        if ($user->save()) {
            Yii::$app->session->setFlash('Success', 'Successfully Deleted User!');
        } else {
            $errors = implode('', $user->getErrors());
            Yii::$app->session->setFlash('Error', $errors);
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
            Yii::$app->session->setFlash('Success', 'Changed User Role to:' . $user->getRole() . '!');
        } else {
            $errors = implode('', $user->getErrors());
            Yii::$app->session->setFlash('Error', 'Failed to Change User Role!');
            Yii::warning('Failed to Change User Role!' . $errors, __METHOD__);
        }
        return $this->redirect('/user/users');
    }
}