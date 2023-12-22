<?php

namespace common\models;


use common\models\query\ProductQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $brand_id
 * @property int type_id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property int $rating
 * @property int $number_of_stocks
 * @property bool $is_activated
 * @property int $is_kid
 * @property int $gender
 *
 * @property Type $type
 * @property Brand $brand
 * @property Rating[]|null $ratings
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
    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    const KID = 0;
    const NOT_KID = 1;

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
            [['name', 'description', 'price', 'number_of_stocks', 'is_kid', 'gender', 'type_id', 'brand_id'], 'required'],
            [['name'], 'string', 'max' => 128],
            ['description', 'string', 'max' => 1024],
            ['rating', 'in', 'range' => [0,1,2,3,4,5]],
            [['number_of_stocks'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number', 'message' => 'Stock number must be 0 or positive!'],
            [['price'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number', 'message' => 'Price must be 0 or positive!'],
            ['is_activated', 'default', 'value' => self::INACTIVE],
            ['is_activated', 'in', 'range' => [self::INACTIVE, self::ACTIVE]],
            [['is_kid'], 'in', 'range' => [self::KID, self::NOT_KID]],
            [['is_kid'], 'default', 'value' => self::NOT_KID],
            [['gender'], 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand Name',
            'type_id' => 'Type',
        ];
    }

    public static function find(): ProductQuery
    {
        return new ProductQuery(get_called_class());
    }

    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    public function getRating(): ActiveQuery
    {
        return $this->hasMany(Rating::class, ['id' => 'product_id']);
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