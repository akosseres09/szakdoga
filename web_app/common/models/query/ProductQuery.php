<?php

namespace common\models\query;

use common\models\Product;
use PhpParser\Node\Expr\PreDec;
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

    public function ofInactive(): ProductQuery
    {
        return $this->andWhere(['is_activated' => Product::INACTIVE]);
    }

    public function ofOnStock(): ProductQuery
    {
        return $this->andWhere(['>=', 'number_of_stocks', 0]);
    }

    public function ofMale(): ProductQuery
    {
        return $this->andWhere(['gender' => Product::GENDER_MALE]);
    }

    public function ofFemale(): ProductQuery
    {
        return $this->andWhere(['gender' => Product::GENDER_FEMALE]);
    }

    public function ofKid(): ProductQuery
    {
        return $this->andWhere(['is_kid' => Product::KID]);
    }

    public function ofAdult(): ProductQuery
    {
       return $this->andWhere(['is_kid' => Product::NOT_KID]);
    }


}