<?php
/**
 * @var View $this
 * @var ActiveDataProvider $orders
 */

use common\widgets\OrderWidget;
use yii\data\ActiveDataProvider;
use yii\web\View;

$this->registerCssFile('/css/shop/shop.css');
$date = Yii::$app->formatter->asDate(Yii::$app->request->get('date'), 'php: Y-m-d H:i:s (D)');

$this->title = 'View Orders';

echo OrderWidget::widget([
    'orders' => $orders
]);
