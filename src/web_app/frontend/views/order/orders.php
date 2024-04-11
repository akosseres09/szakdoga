<?php
/**
 * @var View $this
 * @var ActiveDataProvider $orders
 */

use common\widgets\Pager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

$this->registerCss(<<<CSS
    .table .sub-row-container {
        opacity: 0;
        height: 0;
        transition: opacity 0.2s ease-in;
        overflow: hidden;
    }
    
    .table .sub-row-container.active {
        height: fit-content;
        opacity: 1;
    }
    
    .table .row-expandable {
        transition: all 0.1s ease-in;
        cursor: pointer;
    }

    .table .row-expandable:hover {
        opacity: 0.75;
    }
CSS);

Pjax::begin([
    'enablePushState' => false,
    'enableReplaceState' => false
]);
?>
<div class="table-responsive">
   <?= GridView::widget([
        'dataProvider' => $orders,
        'summary' => false,
        'tableOptions' => [
            'class' => 'table table-hover text-center'
        ],
        'pager' => [
            'class' => Pager::class
        ],
        'rowOptions' => function ($model) {
            return [
                'class' => 'view-invoice-row',
                'style' => 'vertical-align: middle'
            ];
        },
        'columns' => [
            [
                'attribute' => 'created_at',
                'label' => 'Date of Purchase',
                'format' => 'raw',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model['created_at'], 'php:Y-m-d H:i:s (D)');
                }
            ],
            [
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('View Details', ['/order/items?date='.$model['created_at']], [
                        'class' => 'btn btn-outline-dark w-xl-50 ms-auto me-auto'
                    ]);
                }
            ]
        ]
    ]);
?>
</div>
<?php Pjax::end();