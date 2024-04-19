<?php

namespace common\models\search;

use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\db\Expression;


class ProductSearch extends Product
{
    public $brand;
    public $type;
    public $min;
    public $max;
    public $kid;
    public $gender;
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

    public function formName(): string
    {
        return '';
    }

    public function rules(): array
    {
        return [
            [['min', 'max'], 'number'],
            [['min'], 'compare', 'compareAttribute' => 'max', 'type' => 'number', 'operator' => '<='],
            [['brand', 'type'], 'each', 'rule' => ['string']],
            [['name'], 'string', 'max' => 128],
            [['kid'], 'each', 'rule' => ['string']],
            [['gender'], 'each', 'rule' => ['string']],
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
            ->andFilterWhere(['IN', 'type_name', $this->type])
            ->andFilterWhere(['IN', 'brand_name', $this->brand])
            ->andFilterWhere(['IN', 'is_kid', $this->kid])
            ->andFilterWhere(['IN', 'gender', $this->gender])
            ->andFilterWhere(['>=', 'price', $this->min])
            ->andFilterWhere(['<=', 'price', $this->max])
            ->andFilterWhere(['is_activated' => $active]);

        return $dataProvider;
    }
}