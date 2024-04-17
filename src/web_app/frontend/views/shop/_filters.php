<?php
/**
 * @var Brand[] $brands
 * @var Type[] $types
 * @var ProductSearch $searchModel
 * @var int $paramCount
 * @var array $filterTypeCount
 */

use common\models\Brand;
use common\models\Product;
use common\models\search\ProductSearch;
use common\models\Type;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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


$form = ActiveForm::begin([
    'id' => 'shop-filter-form',
    'action' => Url::to(['/shop/products']),
    'method' => 'get'
]); ?>
<?= $form->field($searchModel, 'name', $options)->textInput(['type' => 'search', 'placeHolder' => 'Search']) ?>
<?php if ($paramCount > 0 ) { ?>
    <span class="fw-bold ps-2 brown">You currently have <?=$paramCount?> active Filters</span>
<?php } ?>
<div class="mt-3">
    <?= $form->field($searchModel, 'pageSize')->dropDownList(ProductSearch::PAGE_SIZES) ?>
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
                    Product::ADULT => 'Adult',
                    Product::CHILDREN => 'Children'
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
                        <?= $form->field($searchModel, 'minPrice')->textInput(['type' => 'number', 'placeHolder' => '0'])->label('Min') ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($searchModel, 'maxPrice')->textInput(['type' => 'number', 'placeHolder' => '500'])->label('Max') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center gap-3 align-items-center">
    <?= Html::submitButton('Filter', ['class' => 'btn btn-primary mt-3', 'id' => 'filter-button' ]) ?>
    <?php if ($paramCount > 0) { ?>
        <?= Html::a(Html::button('Reset Filters', ['class' => 'btn btn-outline-dark mt-3']), ['/shop/products']) ?>
    <?php } ?>
</div>
<?php ActiveForm::end() ?>
</div>