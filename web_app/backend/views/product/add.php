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

?>
<div class="modal-dialog">
    <?php $form = ActiveForm::begin([
        'action' => '/product/add'
    ]) ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Create a Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
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
                        1 => 'Adult',
                        0 => 'Kid'
                    ], ['required' => true])->label('Kid or Adult') ?>
                </div>
                <div class="col">
                    <?= $form->field($product, 'gender', $fieldOptions)->dropDownList([
                        1 => 'Male',
                        0 => 'Female'
                    ])?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?= $form->field($product, 'type_id', $fieldOptions)->dropDownList($types) ?>
                </div>
                <div class="col">
                    <?= $form->field($product, 'brand_id', $fieldOptions)->dropDownList($brands) ?>
                </div>
            </div>
            <div class="row">
                <?= $form->field($product, 'description', $fieldOptions)->textarea(['maxlength' => 1024, 'required' => true]) ?>
            </div>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <?= Html::submitButton('Create Product', [
                        'class' => 'btn btn-primary mt-5'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
