<?php

namespace common\models\search;

use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\db\Expression;


class ProductSearch extends Product
{
    public $brandName;
    public $typeName;
    public $minPrice;
    public $maxPrice;
    public $kidOrAdult;
    public $genderName;
    const SEARCH_ON_STOCK = 1;
    const SEARCH_OFF_STOCK = 0;
    public function rules(): array
    {
        return [
            [['minPrice', 'maxPrice'], 'number'],
            [['minPrice'], 'compare', 'compareAttribute' => 'maxPrice', 'type' => 'number', 'operator' => '<='],
            [['brandName'], 'each', 'rule' => ['string']],
            [['typeName'], 'each', 'rule' => ['string']],
            [['name'], 'string', 'max' => 128],
            [['kidOrAdult'], 'each', 'rule' => ['string']],
            [['genderName'], 'each', 'rule' => ['string']]
        ];
    }

    public function search($params, $pageSize): ActiveDataProvider
    {
        $query = Product::find()->ofActive();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);

        if(!($this->load($params)) && $this->validate()) {
            return $dataProvider;
        }

        if (isset($this->brandName)) {
            $query->joinWith(['brand']);
        }
        if (isset($this->typeName)) {
            $query->joinWith(['type']);
        }

        $query->andFilterWhere(['like', new Expression('CONCAT(brand.name, " ", product.name)'), $this->name])
            ->andFilterWhere(['IN', 'type.product_type', $this->typeName])
            ->andFilterWhere(['IN', 'brand.name', $this->brandName])
            ->andFilterWhere(['IN', 'product.is_kid', $this->kidOrAdult])
            ->andFilterWhere(['IN', 'product.gender', $this->genderName])
            ->andFilterWhere(['>=', 'product.price', $this->minPrice])
            ->andFilterWhere(['<=', 'product.price', $this->maxPrice]);

        return $dataProvider;
    }
}