<?php

namespace common\models;

use common\models\query\OrderQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int $quantity
 * @property int $size
 * @property int $created_at
 *
 * @property Product $product
 * @property User $user
 */
class Order extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order}}';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id', 'created_at', 'quantity'], 'integer'],
            ['size', 'string']
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false
            ]
        ];
    }

    public static function find(): OrderQuery
    {
        return new OrderQuery(get_called_class());
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class,  ['id' => 'product_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}