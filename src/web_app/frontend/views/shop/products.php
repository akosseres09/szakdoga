<?php
/**
 * @var View $this
 * @var ArrayDataProvider $dataProvider
 * @var ProductSearch $searchModel
 * @var Type[] $types
 * @var Brand[] $brands
 * @var int $paramCount
 * @var array $filterTypeCount
 */;

use common\models\Brand;
use common\models\Product;
use common\models\search\ProductSearch;
use common\models\Type;
use common\widgets\Pager;
use frontend\assets\ShopAsset;
use yii\bootstrap5\ActiveForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ListView;

ShopAsset::register($this);

echo $this->render('/site/common/_alert');

$this->title = 'The Best Choice In Sports » Sportify ';

echo $this->render('_filters', [
    'brands' => $brands,
    'types' => $types,
    'searchModel' => $searchModel,
    'paramCount' => $paramCount,
    'filterTypeCount' => $filterTypeCount
])

?>
<div class="col-lg-9 mt-5 mt-lg-0 shop-container-search-bar py-3" style="border-radius: 10px;background-color: var(--spfy-background-color)">
    <div class="shop-container">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => Pager::class
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
            'summary' => false,
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
    </div>
</div>



