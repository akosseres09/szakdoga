<?php

namespace common\components;

use common\models\Wishlist;

class WishlistHelper
{
    public static function isInWishlist($userId, $productId): bool
    {
        return Wishlist::find()->ofUser($userId)->ofProduct($productId)->exists();
    }
}