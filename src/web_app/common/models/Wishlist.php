<?php

namespace common\models;

use common\models\query\WishlistQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $added_at
 * @property int $updated_at
 */
class Wishlist extends ActiveRecord
{
    public function rules(): array
    {
        return [
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id'], 'unique', 'message' => 'You already have this product in your wishlist!'],
            [['user_id', 'product_id'], 'number']
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'added_at'
            ]
        ];
    }

    public static function find(): WishlistQuery
    {
        return new WishlistQuery(get_called_class());
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

}