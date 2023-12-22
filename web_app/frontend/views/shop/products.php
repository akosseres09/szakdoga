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
                    <div class="container">
                        <div class="items-grid-container mt-5 mt-lg-0">{items}</div>
                        {pager}
                    </div>
                    <div class="text-center mt-2">{summary}</div>
                </div>'

]);

//d-flex justify-content-center justify-content-lg-start flex-wrap gap-3
?>


