<?php
/**
 * @var View $this
 * @var Product $product
 */

$this->title = 'Add Product to Sportify';

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;use yii\widgets\ActiveForm;

$fieldOptions = [
    'labelOptions' => ['class' => 'mb-1 mt-3']
]


?>


<div class="container-fluid">
    <div class="container">
        <?php $form = ActiveForm::begin([
            'action' => '/product/add'
        ]) ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($product, 'name', $fieldOptions)->textInput(['maxlength' => 128, 'required' => true]); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($product, 'price', $fieldOptions)->textInput(['type' => 'number', 'required' => true])->label('Price (USD)') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($product, 'number_of_stocks', $fieldOptions)->textInput(['type' => 'number', 'required' => true])?>
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
            <div class="col-auto">
                <?= Html::a('Cancel', Url::to(['/product/products']), [
                    'class' => 'btn btn-outline-light mt-sm-5 mt-2 new-prod-form-btn'
                ]) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>