<?php

namespace common\models;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $street
 * @property int $postcode
 *
 * @property User $userId
 */
class ShippingInformation extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'shipping_information';
    }

    public function behaviors(): array
    {
        return [
            BlameableBehavior::class
        ];
    }

    public function rules(): array
    {
        return [
            [['country', 'state', 'street', 'city', 'postcode'], 'required'],
            [['country', 'state', 'street', 'city'], 'string'],
            [['postcode'], 'integer'],
            [['postcode'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'message' => 'The postcode must be positive!']
        ];
    }

    public static function findIdentity($user_id): ?ShippingInformation
    {
        return static::findOne(['user_id' => $user_id]);
    }
}