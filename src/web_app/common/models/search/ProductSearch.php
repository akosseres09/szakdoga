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
    public $pageSize;
    const SEARCH_ON_STOCK = 1;
    const SEARCH_OFF_STOCK = 0;
    const PAGE_SIZES = [
        8 => 8,
        12 => 12,
        16 => 16,
        20 => 20,
        24 => 24,
        28 => 28,
        32 => 32
    ];

    public function formName()
    {
        return '';
    }

    public function rules(): array
    {
        return [
            [['minPrice', 'maxPrice'], 'number'],
            [['minPrice'], 'compare', 'compareAttribute' => 'maxPrice', 'type' => 'number', 'operator' => '<='],
            [['brandName'], 'each', 'rule' => ['string']],
            [['typeName'], 'each', 'rule' => ['string']],
            [['name'], 'string', 'max' => 128],
            [['kidOrAdult'], 'each', 'rule' => ['string']],
            [['genderName'], 'each', 'rule' => ['string']],
            ['pageSize', 'in', 'range' => self::PAGE_SIZES]
        ];
    }

    public function search($params, $active = true): ActiveDataProvider
    {
        $query = Product::find();
        if ($active) {
            $query->ofActive();
        }

        $query->orderBy(['number_of_stocks' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12
            ]
        ]);

        if (!$active) {
            $dataProvider->sort = [
                'defaultOrder' => [
                    'number_of_stocks' => SORT_DESC
                ]
            ];
        }

        if(!($this->load($params)) && $this->validate()) {
            return $dataProvider;
        }

        if (isset($this->pageSize)) {
            $dataProvider->pagination = [
                'pageSize' => $this->pageSize
            ];
        }

        $query->andFilterWhere(['like', new Expression('CONCAT(brand_name, " ", product.name)'), $this->name])
            ->andFilterWhere(['IN', 'type_name', $this->typeName])
            ->andFilterWhere(['IN', 'brand_name', $this->brandName])
            ->andFilterWhere(['IN', 'is_kid', $this->kidOrAdult])
            ->andFilterWhere(['IN', 'gender', $this->genderName])
            ->andFilterWhere(['>=', 'price', $this->minPrice])
            ->andFilterWhere(['<=', 'price', $this->maxPrice])
            ->andFilterWhere(['is_activated' => $active]);

        return $dataProvider;
    }
}