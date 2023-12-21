<?php

namespace common\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $product_id
 * @property string $type
 *
 * @property Product $product
 */

class Type extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'type';
    }

    public function rules(): array
    {
        return [
            [['product_id', 'type'], 'required'],
            [['type'], 'string', 'max' => 32]
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false,
                'updatedAtAttribute' => false
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => false,
                'updatedByAttribute' => false
            ]
        ];
    }

}