<?php

namespace frontend\controllers;

use common\models\Wishlist;
use frontend\components\BaseController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\ErrorAction;
use yii\web\Response;

class WishlistController extends BaseController
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
        $userId = Yii::$app->user->id;
        $query = Wishlist::find()->ofUser($userId);

        $items = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0
            ],
            'sort' => [
                'defaultOrder' => [
                    'added_at' => SORT_DESC
                ]
            ]
        ]);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'data' => $this->renderPartial('wishlist', [
                'wishlistItems' => $items
            ])
        ];
    }
}