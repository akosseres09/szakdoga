<?php

namespace common\models\search;

use common\models\Order;
use common\models\traits\FilterTrait;
use yii\data\ActiveDataProvider;

class OrderSearch extends Order
{
    use FilterTrait;
    public $created_at;
    public string $name = '';

    private int $startDate = 0;
    private int $endDate = 0;

    public function formName(): string
    {
        return '';
    }

    public function rules(): array
    {
        return [
            ['created_at', 'integer'],
            ['name', 'string', 'max' => 255]
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Order::find()->leftJoin('{{%user}}', 'order.user_id = user.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15
            ],
            'sort' => [
                'attributes' => [
                    'order.created_at',
                    'user.username'
                ]
            ]
        ]);

        $this->loadFilter($params, $query);

        $query->andFilterWhere(['like', 'user.username', $this->name]);

        return $dataProvider;
    }
}