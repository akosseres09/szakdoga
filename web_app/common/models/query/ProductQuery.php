<?php

namespace common\models\query;

use common\models\Product;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ProductQuery extends ActiveQuery
{
    public function all($db = null): array
    {
        return parent::all($db);
    }

    public function one($db = null): array|ActiveRecord|null
    {
        return parent::one($db);
    }

    public function ofActive(): ProductQuery
    {
        return $this->andWhere(['is_activated' => Product::ACTIVE]);
    }


}