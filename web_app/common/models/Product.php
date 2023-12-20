<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property int $rating
 * @property int $number_of_stocks
 * @property bool $is_activated
 */


class Product extends ActiveRecord
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    const STATUSES = [
        self::INACTIVE => 'Inactive',
        self::ACTIVE => 'Acitve'
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
            ['is_activated', 'default', 'value' => self::INACTIVE],
            ['is_activated', 'in', 'range' => [self::INACTIVE, self::ACTIVE]]
        ];
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