<?php

namespace common\models\query;

use yii\db\ActiveQuery;

class OrderQuery extends ActiveQuery
{
    public function ofUser($id): OrderQuery
    {
        return $this->andWhere(['user_id' => $id]);
    }

    public function ofDate($date): OrderQuery
    {
        return $this->andWhere(['created_at' => $date]);
    }
}