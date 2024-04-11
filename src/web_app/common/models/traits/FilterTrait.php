<?php

namespace common\models\traits;

use Yii;

trait FilterTrait
{
    public function loadFilter(&$params, $query)
    {
        if(!empty($params['created_at'])) {
            $params['created_at'] = strtotime($params['created_at']);
        }

        if (!($this->load($params) && $this->validate())) {
            return $query;
        }

        if (!empty($this->created_at)) {
            $date = Yii::$app->formatter->asDate($this->created_at, 'php:Y-m-d');
            $this->startDate = strtotime($date);
            $this->endDate = strtotime('+1 day', $this->created_at);

            $query->andFilterWhere(['>=', $this->tableName().'.created_at', $this->startDate])
                ->andFilterWhere(['<', $this->tableName().'.created_at', $this->endDate]);
        }

        return $query;
    }
}