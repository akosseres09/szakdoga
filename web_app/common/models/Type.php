<?php

namespace common\models;

use common\models\query\TypeQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $product_type
 */
class Type extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%type}}';
    }

    public function rules(): array
    {
        return [
            [['product_type'], 'required'],
            [['product_type'], 'string', 'max' => 128]
        ];
    }

    public function behaviors()
    {
        return [];
    }

    public static function find(): TypeQuery
    {
        return new TypeQuery(get_called_class());
    }

}