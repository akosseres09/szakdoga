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
        $query->with(['brand', 'type']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12
            ]
        ]);

        if (!$active) {
            $dataProvider->sort = [
                'defaultOrder' => [
                    'is_activated' => SORT_DESC
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

        if (isset($this->typeName)) {
            $query->joinWith(['type']);
        }

        if (isset($this->brandName)) {
            $query->joinWith(['brand']);
        }

        $query->andFilterWhere(['like', new Expression('CONCAT(brand.name, " ", product.name)'), $this->name])
            ->andFilterWhere(['IN', 'type.product_type', $this->typeName])
            ->andFilterWhere(['IN', 'brand.name', $this->brandName])
            ->andFilterWhere(['IN', 'product.is_kid', $this->kidOrAdult])
            ->andFilterWhere(['IN', 'product.gender', $this->genderName])
            ->andFilterWhere(['>=', 'product.price', $this->minPrice])
            ->andFilterWhere(['<=', 'product.price', $this->maxPrice])
            ->andFilterWhere(['product.is_activated' => $active]);

        return $dataProvider;
    }
}