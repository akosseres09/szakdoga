<?php
/**
 * @var View $this
 * @var ArrayDataProvider $dataProvider
 */

use yii\bootstrap5\LinkPager;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ListView;

$this->title = 'The Best Choice In Sports » Sportify '; ?>


<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'pager' => [
        'class' => LinkPager::class
    ],
    'emptyText' => 'No result found',
    'emptyTextOptions' => ['class' => 'fs-5 fw-bold'],
    'itemView' => '_productItem',
    'itemOptions' => function ($model) {
        return [
            'class' => 'card product-container product-item-link',
            'tag' => 'a',
            'href' => Url::to(['/shop/view/'.$model->id])
        ];
    },
    'summary' => '{begin}-{end}/{totalCount}',
    'layout' => '<div class="container-fluid position-relative">
                    <div class="text-center mb-5">{summary}</div>
                    <div class="container mb-5">
                        <div class="items-grid-container">{items}</div>
                    </div>
                    <div class="d-flex justify-content-center">
                        {pager}
                    </div>
                </div>'

]);

?>


