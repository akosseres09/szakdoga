<?php

namespace common\models\query;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class BrandQuery extends ActiveQuery
{
    public function all($db = null): array
    {
        return parent::all($db);
    }

    public function one($db = null): array|ActiveRecord|null
    {
        return parent::one($db);
    }
}