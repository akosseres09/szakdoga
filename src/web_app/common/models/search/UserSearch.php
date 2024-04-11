<?php

namespace common\models\search;

use common\models\traits\FilterTrait;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    use FilterTrait;

    public $username;
    public $email;
    public $is_admin;
    public $status;
    public $created_at;

    private int $startDate = 0;
    private int $endDate = 0;

    const ALL_TYPE = 2;
    const ALL_STATUS = 1;
    public function formName(): string
    {
        return '';
    }

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->created_at = strtotime('now');
    }

    public function rules(): array
    {
        return [
            [['username', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            [['is_admin'], 'in', 'range' => [self::USER, self::ADMIN, self::ALL_TYPE]],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::ALL_STATUS]],
            [['created_at'], 'integer']
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15
            ],
            'sort' => [
                'attributes' => [
                    'username',
                    'email',
                    'is_admin',
                    'created_at',
                    'updated_at',
                    'status'
                ]
            ]
        ]);

        $this->loadFilter($params, $query);

        if ($this->is_admin !== '2') {
            $query->andFilterWhere(['=', 'is_admin', $this->is_admin]);
        }

        if ($this->status !== '1') {
            $query->andFilterWhere(['=', 'status', $this->status]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}