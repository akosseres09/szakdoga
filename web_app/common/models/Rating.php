<?php

namespace common\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
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
    const RATING_VERY_LOW = 0;
    const RATING_LOW = 1;
    const RATING_MEDIUM = 2;
    const RATING_HIGH = 3;
    const RATING_VERY_HIGH = 4;
    const RATING_EXCELLENT = 5;

    const RATINGS = [
        self::RATING_VERY_LOW => 'Very Negative',
        self::RATING_LOW => 'Negative',
        self::RATING_MEDIUM => 'Medium',
        self::RATING_HIGH => 'Mostly Positive',
        self::RATING_VERY_HIGH => 'Very Positive',
        self::RATING_EXCELLENT => 'Excellent'
    ];

    public static function tableName(): string
    {
        return '{{%rating}}';
    }
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false,
                'UpdatedAtAttribute' => false
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => false,
                'updatedByAttribute' => false
            ]
        ];
    }

    public function rules(): array
    {
        return [
            [['user_id', 'product_id', 'rating'], 'required'],
            [['rating'], 'in', 'range' => [self::RATING_VERY_LOW, self::RATING_LOW, self::RATING_MEDIUM, self::RATING_HIGH, self::RATING_VERY_HIGH, self::RATING_EXCELLENT]],
            [['description'], 'string', 'max' => 2048]
        ];
    }


}