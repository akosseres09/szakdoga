<?php

namespace common\models;


use common\models\query\ProductQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property int $rating
 * @property int $number_of_stocks
 * @property bool $is_activated
 *
 * @property Type[]|null types
 * @property Rating[]|null ratings
 */


class Product extends ActiveRecord
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    const STATUSES = [
        self::INACTIVE => 'Inactive',
        self::ACTIVE => 'Active'
    ];
    const OUT_OF_STOCK = 'Out of Stock';
    const ON_STOCK = 'On Stock';

    public static function tableName(): string
    {
        return 'product';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false,
                'updatedAtAttribute' => false
            ]
        ];
    }

    public function rules(): array
    {
        return [
            [['name', 'description', 'price', 'number_of_stocks'], 'required'],
            [['name'], 'string', 'max' => 128],
            ['description', 'string', 'max' => 1024],
            ['rating', 'in', 'range' => [0,1,2,3,4,5]],
            [['number_of_stocks'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number', 'message' => 'Stock number must be 0 or positive!'],
            [['price'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number', 'message' => 'Price must be 0 or positive!'],
            ['is_activated', 'default', 'value' => self::INACTIVE],
            ['is_activated', 'in', 'range' => [self::INACTIVE, self::ACTIVE]]
        ];
    }

    public static function find(): ProductQuery
    {
        return new ProductQuery(get_called_class());
    }

    public function getAllRatingsToProduct(): ActiveQuery
    {
        return $this->hasMany(Rating::class, ['product_id' => $this->id]);
    }

    public function getAllTypesToProduct(): ActiveQuery
    {
        return $this->hasMany(Type::class, ['product_id' => $this->id]);
    }

    public function getActiveStatus(): string
    {
        return self::STATUSES[$this->is_activated];
    }

    public function getAvailability(): string
    {
        return $this->number_of_stocks === 0 ? self::OUT_OF_STOCK : self::ON_STOCK;
    }


}