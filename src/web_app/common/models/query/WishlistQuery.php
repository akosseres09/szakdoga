<?php

namespace common\models\query;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class WishlistQuery extends ActiveQuery
{
    public function all($db = null): array
    {
        return parent::all($db);
    }

    public function one($db = null): array|ActiveRecord|null
    {
        return parent::one($db);
    }

    public function ofUser($id): WishlistQuery
    {
        return $this->andWhere(['user_id' => $id]);
    }

    public function ofProduct($id): WishlistQuery
    {
        return $this->andWhere(['product_id' => $id]);
    }

    public function ofId(int $id): WishlistQuery
    {
        return $this->andWhere(['id' => $id]);
    }


}