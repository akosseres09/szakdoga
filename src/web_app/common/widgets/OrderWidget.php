<?php

namespace common\widgets;

use yii\base\Widget;
use yii\data\ActiveDataProvider;

class OrderWidget extends Widget
{
    public ActiveDataProvider $orders;
    public function init(): void
    {
        parent::init();
    }

    public function run()
    {
        return $this->renderFile('@common/widgets/views/orderView.php', [
            'orders' => $this->orders,
        ]);
    }
}