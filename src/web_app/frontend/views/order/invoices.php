<?php
/**
 * @var View $this
 * @var ArrayDataProvider $invoices
 */

use common\widgets\Pager;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

Pjax::begin([
    'enablePushState' => false,
    'enableReplaceState' => false
]);

echo GridView::widget([
    'dataProvider' => $invoices,
    'summary' => false,
    'pager' => [
        'class' => Pager::class
    ],
    'tableOptions' => [
        'class' => 'table table-responsive table-hover table-striped text-center',
    ],
    'rowOptions' => function ($model) {
        return [
            'class' => 'view-invoice-row',
            'style' => 'vertical-align: middle'
        ];
    },
    'columns' => [
        [
            'attribute' => 'paid',
            'label' => 'Status',
            'format' => 'raw' ,
            'value' => function ($model) {
                return $model->paid ? '<span class="status-paid">PAID</span>' : '<span class="status-incoming">INCOMING</span>';
            }
        ],
        [
            'attribute' => 'amount_due',
            'label' => 'Amount Charged',
            'format' => 'raw',
            'value' => function ($model) {
                return '$'. number_format((float)$model->amount_due / 100, 2, '.', ' ') ;
            }
        ],
        [
            'attribute' => 'amount_paid',
            'label' => 'Amount Paid',
            'format' => 'raw',
            'value' => function ($model) {
                return '$'. number_format((float)$model->amount_paid / 100, 2, '.', ' ') ;
            }
        ],
        [
            'attribute' => 'hosted_invoice_url',
            'label' => 'View Invoice',
            'format' => 'raw',
            'value' => function ($model) {
                $img = '<span class="ps-2 material-symbols-outlined">arrow_forward</span>';
                return Html::a('View invoice' . $img, $model->hosted_invoice_url, ['target' => '_blank', 'class' => 'invoice-link btn btn-outline-dark w-50 ms-auto me-auto']);
            }
        ]
    ]
]);

Pjax::end();

