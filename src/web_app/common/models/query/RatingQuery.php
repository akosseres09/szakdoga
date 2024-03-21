<?php

namespace common\models\query;

use yii\db\ActiveQuery;

class RatingQuery extends ActiveQuery
{

    public function ofUser($id): RatingQuery
    {
        return $this->andWhere(['user_id' => $id]);
    }

    public function ofProduct($id): RatingQuery
    {
        return $this->andWhere(['product_id' => $id]);
    }
}