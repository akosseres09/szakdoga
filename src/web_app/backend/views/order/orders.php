<?php
/**
 * @var View $this
 * @var ActiveDataProvider $orders
 * @var OrderSearch $search
 */

use common\models\search\OrderSearch;
use common\widgets\Pager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\web\View;

$this->title = 'Orders';

?>

<div class="my-4">
    <h1 class="text-center">Orders</h1>
</div>

<?=
    GridView::widget([
        'dataProvider' => $orders,
        'filterModel' => $search,
        'columns' => [
            [
                'class' => SerialColumn::class
            ],
            [
                'attribute' => 'user.username',
                'filterAttribute' => 'name',
                'label' => 'Ordered By',
                'value' => function ($model) {
                    return $model->user->username;
                },
                'headerOptions' => [
                    'style' => 'min-width: 150px;width: 250px'
                ]
            ],
            [
                'attribute' => 'order.created_at',
                'format' => 'raw',
                'label' => 'Ordered At',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d H:i:s');
                },
                'filter' => DatePicker::widget([
                    'model' => $search,
                    'attribute' => 'created_at',
                    'dateFormat' => 'php:Y-m-d',
                    'options' => [
                        'class' => 'form-control'
                    ],
                ]),
                'headerOptions' => [
                    'style' => 'min-width: 200px; width: 400px'
                ]
            ],
            [
                'label' => 'View',
                'format' => 'raw',
                'value' => function ($model) {
                    $href = Url::to(["/order/view/$model->user_id?date=$model->created_at" ]);
                    return Html::a('View Order', $href);
                }
            ]
        ],
        'options' => ['class' => 'mx-5'],
        'tableOptions' => ['class' => 'table table-striped text-center align-middle'],
        'pager' => [
            'class' => Pager::class
        ],
        'layout' => '<div class="table-responsive">{items}</div>{pager}',
    ])
?>
