<?php

namespace frontend\components;

use common\models\Cart;
use common\models\User;
use common\models\Wishlist;
use yii\base\ActionFilter;

class UserLoaderFilter extends ActionFilter
{
    public array $relations;

    public function beforeAction($action): bool
    {
        try {
            $user = User::findIdentity(\Yii::$app->user->id);
            $user->populateRelation('carts', Cart::findByUser($user->id));
            $user->populateRelation('wishlistItems', Wishlist::findByUser($user->id));

        } catch (\Exception $e) {
        }

        return parent::beforeAction($action);
    }
}