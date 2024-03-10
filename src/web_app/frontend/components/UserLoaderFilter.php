<?php

namespace frontend\components;

use common\models\Cart;
use common\models\User;
use common\models\Wishlist;
use Yii;
use yii\base\ActionFilter;

class UserLoaderFilter extends ActionFilter
{
    public function beforeAction($action): bool
    {
        try {
            if (!Yii::$app->user->isGuest) {
                $user = User::findIdentity(Yii::$app->user->id);
                $user->populateRelation('cart', Cart::findByUser($user->id));
                $user->populateRelation('wishlist', Wishlist::findByUser($user->id));
            }
        } catch (\Exception $e) {
        }

        return parent::beforeAction($action);
    }
}