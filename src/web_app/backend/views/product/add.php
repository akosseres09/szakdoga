<?php
/**
 * @var View $this
 * @var Product $product
 * @var Brand[] $brands
 * @var Type[] $types
 */

$this->title = 'Add Product to Sportify';

use common\models\Brand;
use common\models\Product;
use common\models\Type;
use yii\helpers\Html;
use yii\web\View;use yii\widgets\ActiveForm;

$fieldOptions = [
    'labelOptions' => ['class' => 'mb-1 mt-3']
];

$this->registerCss(<<<CSS
    input[type="file"] {
        display: none;
    }

    #uploadedImagesContainer {
        padding: 0 calc(var(--bs-gutter-x) * 0.5) ;
        max-height: 500px;
        margin-top: 10px;
        display: flex;
        justify-content: start;
        align-items: center;
        gap: 10px;
    }

    #uploadedImagesContainer img {
        max-height: 200px;
        max-width: fit-content;
        aspect-ratio: 4/3;
        padding: 0 !important;
    }
CSS
);
?>
<div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Create a Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data'
                ],
                'action' => '/product/add',
            ]) ?>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($product, 'name', $fieldOptions)->textInput(['maxlength' => 128, 'required' => true]); ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($product, 'price', $fieldOptions)->textInput(['type' => 'number','min' => 0, 'required' => true])->label('Price (USD)') ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($product, 'number_of_stocks', $fieldOptions)->textInput(['type' => 'number', 'min' => 0, 'required' => true])?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg">
                    <?= $form->field($product, 'is_kid', $fieldOptions)->dropDownList([
                        Product::CHILDREN => 'Children',
                        Product::ADULT => 'Adult'
                    ], ['required' => true])->label('Kid or Adult') ?>
                </div>
                <div class="col">
                    <?= $form->field($product, 'gender', $fieldOptions)->dropDownList([
                        Product::GENDER_MALE => 'Male',
                        Product::GENDER_FEMALE => 'Female'
                    ])?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?= $form->field($product, 'type_name', $fieldOptions)->dropDownList($types) ?>
                </div>
                <div class="col">
                    <?= $form->field($product, 'brand_name', $fieldOptions)->dropDownList($brands) ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="mt-4">Upload files </label>
                    <?= $form->field($product, 'images[]', [
                        'labelOptions' => ['class' => 'd-none', 'id' => 'file-upload'],
                        'inputOptions' => ['class' => 'mt-2']
                    ])->fileInput(['multiple' => true, 'accept' => 'image/png, image/jpg, image/jpeg, image/webp', 'onchange' => 'showFiles(event)'])?>
                    <button type="button" onclick="triggerFileSelect()" class="btn btn-outline-dark" id="custom-file-upload">Select Images</button>
                </div>
            </div>
            <div class="row" id="uploadedImagesContainer">
                <div class="delete-btn">

                </div>
            </div>
            <div class="row">
                <?= $form->field($product, 'description_title', $fieldOptions)->textInput(['maxlength' => 128, 'required' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($product, 'description', $fieldOptions)->textarea(['maxlength' => 1024, 'required' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($product, 'details', $fieldOptions)->textarea(['maxlength' => 1024, 'required' => true]) ?>
            </div>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <?= Html::submitButton('Create Product', [
                        'class' => 'btn btn-primary mt-5'
                    ]) ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>