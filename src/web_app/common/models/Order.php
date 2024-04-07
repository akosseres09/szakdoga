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
 * @property int $created_at
 *
 * @property Product $product
 */
class Order extends ActiveRecord
{
    public function rules(): array
    {
        return [
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id', 'created_at'], 'integer']
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

}