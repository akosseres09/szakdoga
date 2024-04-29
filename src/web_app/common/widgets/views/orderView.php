<?php
/**
 * @var View $this
 * @var ArrayDataProvider $orders
 */

use common\assets\OrderAsset;
use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\widgets\ListView;

$date = Yii::$app->formatter->asDate(Yii::$app->request->get('date'), 'php: Y-m-d H:i:s (D)');
$this->title = 'View Orders';

OrderAsset::register($this);
?>
    <h3 class="text-center mt-5">
        Products ordered at <?= $date ?>
    </h3>
<?php
echo ListView::widget([
    'dataProvider' => $orders,
    'summary' => false,
    'itemView' => '_orderItem',
    'viewParams' => [
        'total' => $orders->totalCount
    ],
    'layout' => '<div class="container mb-5">
                        <div class="orders-grid-container">{items}</div>
                </div>'
]);

