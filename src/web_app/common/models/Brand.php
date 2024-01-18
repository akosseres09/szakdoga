<?php

namespace common\models;

use common\models\query\BrandQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 */

class Brand extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%brand}}';
    }

    public function behaviors(): array
    {
        return [];
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128]
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'Id',
            'name' => 'Brand Name'
        ];
    }

    public static function find(): BrandQuery
    {
        return new BrandQuery(get_called_class());
    }

}