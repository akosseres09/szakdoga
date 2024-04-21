<?php
/**
 * @var View $this
 * @var ArrayDataProvider $orders
 */

use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\widgets\ListView;

$this->registerCssFile('/css/shop/shop.css');
$date = Yii::$app->formatter->asDate(Yii::$app->request->get('date'), 'php: Y-m-d H:i:s (D)');

$this->title = 'View Orders';

$this->registerCss(<<<CSS
    .orders-grid-container {
        display: grid;
        column-gap: 25px;
        grid-template-columns: repeat(4,minmax(150px, 1fr));
        row-gap: 15px;
    }
    
    @media screen and (max-width: 992px) and (min-width: 768px) {
        .orders-grid-container {
            grid-template-columns: repeat(3,minmax(150px, 1fr));
        }
    }
    
    @media screen and (min-width: 480px) and (max-width: 768px){
        .orders-grid-container {
            grid-template-columns: repeat(2, minmax(150px, 1fr));
        }
    }
    
    @media screen and (max-width: 480px) {
        .orders-grid-container {
            grid-template-columns: repeat(1, minmax(150px, 1fr));
        }
    }
CSS);

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

