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
use frontend\assets\ShopAsset;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\LinkPager;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ListView;

ShopAsset::register($this);

$options = [
    'inputOptions' => [
        'class' => 'form-control',
        'id' => 'filter-search'
    ],
    'template' => '<div class="mb-3 form-floating">
                {input}{label}{error}
                </div>'
];

$accOptions = [
    'template' => '{input}{error}'
];

$this->title = 'The Best Choice In Sports » Sportify ';
?>

<?php $form = ActiveForm::begin([
    'id' => 'shop-filter-form',
    'action' => Url::to(['/shop/products']),
    'method' => 'get'
]); ?>
<?= $form->field($searchModel, 'name', $options)->textInput(['type' => 'search', 'placeHolder' => 'Search']) ?>
<?php if ($paramCount > 0 ) { ?>
    <span class="fw-bold ps-2 brown">You currently have <?=$paramCount?> active Filters</span>
<?php } ?>
<div class="mt-3">
        <?= $form->field($searchModel, 'pageSize')->dropDownList([
            8 => 8,
            12 => 12,
            16 => 16,
            20 => 20
        ]) ?>
</div>
<div class="accordion accordion-flush" id="formFilterAccordion">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#TypeFilter" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                Type <?= isset($filterTypeCount['typeName']) ? '(' . $filterTypeCount['typeName'] . ')' : '' ?>
            </button>
        </h2>
        <div id="TypeFilter" class="accordion-collapse collapse">
            <div class="accordion-body">
                <div>
                    <?= $form->field($searchModel, 'typeName', $accOptions)->checkboxList($types) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#BrandFilter" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                Brand <?= isset($filterTypeCount['brandName']) ? '(' . $filterTypeCount['brandName'] . ')' : '' ?>
            </button>
        </h2>
        <div id="BrandFilter" class="accordion-collapse collapse">
            <div class="accordion-body">
                <?=
                    $form->field($searchModel, 'brandName', $accOptions)->checkboxList($brands);
                ?>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#SizeFilter" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                Kid/Adult <?= isset($filterTypeCount['KidOrAdult']) ? '(' . $filterTypeCount['KidOrAdult'] . ')' : '' ?>
            </button>
        </h2>
        <div id="SizeFilter" class="accordion-collapse collapse">
            <div class="accordion-body">
                <?= $form->field($searchModel, 'kidOrAdult', $accOptions)->checkboxList([
                    Product::KID => 'Children',
                    Product::NOT_KID => 'Adult'
                ]) ?>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#GenderFilter" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                Gender <?= isset($filterTypeCount['genderName']) ? '(' . $filterTypeCount['genderName'] . ')' : '' ?>
            </button>
        </h2>
        <div id="GenderFilter" class="accordion-collapse collapse">
            <div class="accordion-body">
                <?= $form->field($searchModel, 'genderName', $accOptions)->checkboxList([
                    Product::GENDER_MALE => 'Male',
                    Product::GENDER_FEMALE => 'Female'
                ]) ?>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#PriceFilter" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                Price <?= isset($filterTypeCount['maxPrice']) || isset($filterTypeCount['minPrice'])  ? '(' . $filterTypeCount['minPrice'] + $filterTypeCount['maxPrice'] . ')' : '' ?>
            </button>
        </h2>
        <div id="PriceFilter" class="accordion-collapse collapse">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-6">
                        <?= $form->field($searchModel, 'minPrice')->textInput(['type' => 'number'])->label('Min') ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($searchModel, 'maxPrice')->textInput(['type' => 'number'])->label('Max') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center gap-3 align-items-center">
    <?= Html::submitButton('Filter', ['class' => 'btn btn-primary mt-3', 'id' => 'filter-button' ]) ?>
    <?php if ($paramCount > 0) { ?>
        <?= Html::a(Html::button('Reset Filters', ['class' => 'btn btn-outline-light mt-3']), ['/shop/products']) ?>
    <?php } ?>
</div>
<?php ActiveForm::end() ?>
</div>
<div class="col-lg-9 mt-5 mt-lg-0 shop-container-search-bar py-3" style="border-radius: 10px;background-color: var(--spfy-background-color)">
    <div class="shop-container">
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
    </div>
</div>



