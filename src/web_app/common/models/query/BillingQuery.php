<?php

namespace common\models\query;


use yii\db\ActiveQuery;

class BillingQuery extends ActiveQuery
{
    public function ofUser($id): BillingQuery
    {
        return $this->andWhere(['user_id' => $id]);
    }

}