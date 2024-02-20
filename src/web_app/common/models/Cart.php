<?php

namespace common\models;

use common\models\query\CartQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $price
 * @property int $quantity
 * @property string $size
 */
class Cart extends ActiveRecord
{
    const QUANTITY_ONE = 1;
    const KID_SIZES = ["24", "25", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "36 2/3", "37", "37 1/3", "38", "38 2/3"];
    const ADULT_SIZES = ["39 1/3", "40", "40 2/3", "41 1/3", "42", "42 2/3", "43 1/3", "44", "44 2/3", "45 1/3", "46", "46 2/3"];
    public static function tableName(): string
    {
        return '{{%cart}}';
    }

    public function behaviors(): array
    {
        return [];
    }

    public function rules(): array
    {
        return [
            [['user_id', 'product_id', 'price', 'quantity'], 'required'],
            [['quantity'], 'default', 'value' => self::QUANTITY_ONE],
            [['quantity'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number'],
            [['price'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number'],
            [['size'], 'required', 'message' => 'You must choose a size!'],
//            [['size'], 'required', 'when' => function () {
//                    return Product::findOne($this->product_id)->isShoe();
//            }, 'message' => 'You must choose a size!'],
//            [['size'], 'in', 'range' => self::KID_SIZES,'strict' => false, 'when' => function () {
//                $prod = Product::findOne($this->product_id);
//                return $prod->isKid() && $prod->isShoe();
//            }],
//            [['size'], 'in', 'range' => self::ADULT_SIZES,'strict' => false ,'when' => function(){
//                $prod = Product::findOne($this->product_id);
//                return !$prod->isKid() && $prod->isShoe();
//            }]
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