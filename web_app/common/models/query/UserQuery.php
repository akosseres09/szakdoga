<?php

namespace common\models\query;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class UserQuery extends ActiveQuery
{
    public function all($db = null): array
    {
        return parent::all($db);
    }

    public function one($db = null): array|ActiveRecord|null
    {
        return parent::one($db);
    }

    public function ofWhislistItem($id): UserQuery
    {
        return $this->joinWith('wishlist')->andWhere(['wishlist.product_id' => $id]);
    }
}