<?php

namespace common\models;

use common\models\query\CartQuery;
use Yii;
use yii\base\Event;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $price
 * @property int $quantity
 * @property string $size
 * @property int $added_at
 * @property int $updated_at
 *
 * @property User $user
 * @property Product $product
 */
class Cart extends ActiveRecord
{
    const QUANTITY_ONE = 1;
    const KID_SIZES = ["24", "25", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "36 2/3", "37", "37 1/3", "38", "38 2/3"];
    const ADULT_SIZES = ["39 1/3", "40", "40 2/3", "41 1/3", "42", "42 2/3", "43 1/3", "44", "44 2/3", "45 1/3", "46", "46 2/3"];
    const CART_CAHCE_KEY = 'cart';
    public static function tableName(): string
    {
        return '{{%cart}}';
    }

    public function init(): void
    {
        parent::init();
        $this->on(self::EVENT_AFTER_INSERT, [Cart::class, 'clearCache']);
        $this->on(self::EVENT_BEFORE_DELETE, [Cart::class, 'clearCache']);
        $this->on(self::EVENT_AFTER_UPDATE, [Cart::class, 'clearCache']);
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

    public function rules(): array
    {
        return [
            [['user_id', 'product_id', 'price', 'quantity'], 'required'],
            [['quantity'], 'default', 'value' => self::QUANTITY_ONE],
            [['quantity'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number'],
            [['price'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number'],
            [['size'], 'required', 'message' => 'You must choose a size!'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product' => 'Product ID',
            'price' => 'Price',
            'quantity' => 'Quantity'
        ];
    }

    public static function clearCache(Event $event): void
    {
        $cart = $event->sender;

        static::deleteCache(static::getCacheKey($cart->user_id));
    }

    public static function deleteCache(mixed $key): void
    {
        Yii::$app->cache->delete($key);
    }

    public static function getCacheKey(int $id): string
    {
        return self::CART_CAHCE_KEY . $id;
    }

    public static function findByUser(int $id)
    {
        return Yii::$app->cache->getOrSet(static::getCacheKey($id), function () use ($id) {
            return Cart::find()->ofUser($id);
        });
    }

    public static function find(): CartQuery
    {
        return new CartQuery(get_called_class());
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