<?php

namespace common\models\query;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class TypeQuery extends ActiveQuery
{
    public function all($db = null): array
    {
        return parent::all($db);
    }

    public function one($db = null): array|ActiveRecord|null
    {
        return parent::one($db);
    }

    public function ofType($type_name): TypeQuery
    {
        return $this->andWhere(['product_type' => $type_name]);
    }

    public function ofShoes(): TypeQuery
    {
        return $this->andWhere(['like', 'product_type', '%Shoes%', false]);
    }
}