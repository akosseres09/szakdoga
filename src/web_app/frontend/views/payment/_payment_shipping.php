<?php

use common\models\ShippingInformation;
use yii\web\View;
use yii\widgets\ActiveForm;
/**
 * @var View $this
 * @var ShippingInformation $shipping
 * @var ActiveForm $form
 */

?>

<h4 class="mt-3">Shipping Information</h4>
<div class="shippingContainer">
    <div class="shippingCheck">
        <div class="shippingFormRaw">
            <span class="editIcon material-symbols-outlined">
                edit
            </span>
            <div class="address">
                <div class="row">
                    <?= $shipping->country ?>,
                    <?= $shipping->state ?>
                </div>
                <div class="row text-muted">
                    <?= $shipping->postcode ?>
                    <?= $shipping->city ?>
                    <?= $shipping->street ?>
                </div>
            </div>
        </div>
    </div>
    <div class="shippingForm d-none">
        <div class="row">
            <div class="col">
                <?= $form->field($shipping, 'country')->textInput(['maxlength' => 128, 'placeHolder' => 'Country'])->label(false) ?>
            </div>
            <div class="col">
                <?= $form->field($shipping, 'state')->textInput(['maxlength' => 64, 'placeHolder' => 'State'])->label(false) ?>
            </div>
            <div class="col">
                <?= $form->field($shipping, 'postcode')->textInput(['placeHolder' => 'Post Code'])->label(false) ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <?= $form->field($shipping, 'city')->textInput(['maxlength' => 64, 'placeHolder' => 'City'])->label(false) ?>
            </div>
            <div class="col">
                <?= $form->field($shipping, 'street')->textInput(['maxlength' => 64, 'placeHolder' => 'Street'])->label(false) ?>
            </div>
        </div>
    </div>
</div>
