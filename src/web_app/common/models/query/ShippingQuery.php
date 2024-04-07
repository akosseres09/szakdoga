<?php

namespace common\models\query;

use yii\db\ActiveQuery;

class ShippingQuery extends ActiveQuery
{
    public function ofUser($id): ShippingQuery
    {
        return $this->andWhere(['user_id' => $id]);
    }
}