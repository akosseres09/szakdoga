<?php

namespace common\models;

use common\models\query\WishlistQuery;
use Yii;
use yii\base\Event;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $added_at
 * @property int $updated_at
 *
 * @property User $user
 * @property Product $product
 */
class Wishlist extends ActiveRecord
{
    const WISHLIST_CACHCE_KEY = 'wishlist';
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_INSERT, [static::class, 'clearCache']);
        $this->on(self::EVENT_BEFORE_DELETE, [static::class, 'clearCache']);
        $this->on(self::EVENT_BEFORE_UPDATE, [static::class, 'clearCache']);
    }

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

    public static function clearCache(Event $event): void
    {
        $wishlist = $event->sender;

        static::deleteCache(static::getCacheKey($wishlist->user_id));
    }

    public static function deleteCache(mixed $key): void
    {
        Yii::$app->cache->delete($key);
    }

    public static function getCacheKey(int $id): string
    {
        return self::WISHLIST_CACHCE_KEY . $id;
    }

    public static function findByUser(int $id)
    {
        return Yii::$app->cache->getOrSet(self::getCacheKey($id), function () use ($id) {
            return Wishlist::find()->ofUser($id);
        });
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