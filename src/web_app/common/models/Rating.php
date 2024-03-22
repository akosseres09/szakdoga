<?php

namespace common\models;

use common\models\query\RatingQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $rating
 * @property string $description
 *
 * @property User $user
 * @property Product $product
 */

class Rating extends ActiveRecord
{
    const RATING_VERY_LOW = 1;
    const RATING_LOW = 2;
    const RATING_MEDIUM = 3;
    const RATING_HIGH = 4;
    const RATING_EXCELLENT = 5;

    const RATINGS_NAME = [
        self::RATING_VERY_LOW => 'Very Negative',
        self::RATING_LOW => 'Negative',
        self::RATING_MEDIUM => 'Medium',
        self::RATING_HIGH => 'Mostly Positive',
        self::RATING_EXCELLENT => 'Excellent'
    ];

    const RATINGS = [
        self::RATING_VERY_LOW,
        self::RATING_LOW,
        self::RATING_MEDIUM,
        self::RATING_HIGH,
        self::RATING_EXCELLENT
    ];

    public function formName()
    {
        return '';
    }

    public static function tableName(): string
    {
        return '{{%rating}}';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'product_id', 'rating'], 'required'],
            [['rating'], 'in', 'range' => self::RATINGS],
            [['description'], 'string', 'max' => 2048]
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['product_id' => 'id']);
    }

    public static function find(): RatingQuery
    {
        return new RatingQuery(get_called_class());
    }

}