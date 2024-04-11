<?php

namespace common\models\search;

use common\models\Order;
use common\models\traits\FilterTrait;
use yii\data\ActiveDataProvider;
use yii\db\Query;

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
        $query = (new Query())->select([
            'order.created_at AS created_at',
            'user.username AS name',
            'user.id AS id'
        ])->distinct()
        ->from('{{%order}}')
        ->leftJoin('{{%user}}', 'order.user_id = user.id');

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