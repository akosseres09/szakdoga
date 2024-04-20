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

    public function ofId(int $id): UserQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    public function ofDeleted(bool $deleted = false): UserQuery
    {
        if ($deleted) {
            return $this->andWhere(['!=', 'deleted_at' => null]);
        } else {
            return $this->andWhere(['deleted_at' => null]);
        }
    }

    public function ofWhislistItem($id): UserQuery
    {
        return $this->joinWith('wishlist')->andWhere(['wishlist.product_id' => $id]);
    }
}