<?php
/**
 * @var View $this
 * @var ActiveDataProvider $orders
 */

use common\widgets\OrderWidget;
use yii\data\ActiveDataProvider;
use yii\web\View;

echo OrderWidget::widget([
    'orders' => $orders
])

?>
