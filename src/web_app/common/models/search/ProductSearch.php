<?php

namespace common\models\search;

use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;


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

    public function search($params): ActiveDataProvider
    {
        $query = Product::find()->ofActive();
        $query->joinWith(['brand', 'type']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        if(!($this->load($params)) && $this->validate()) {
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'product.name', $this->name])
        ->andFilterWhere(['like', 'brand.name', $this->brandName])
            ->andFilterWhere(['like', 'type.product_type', $this->typeName])
            ->andFilterWhere(['=', 'is_kid', $this->kidOrAdult])
            ->andFilterWhere(['=', 'gender', $this->genderName])
            ->andFilterWhere(['>=', 'price', $this->minPrice])
            ->andFilterWhere(['<=', 'price', $this->maxPrice]);


//        VarDumper::dump($dataProvider->getModels(), 10, true);
//        die();

        return $dataProvider;
    }
}