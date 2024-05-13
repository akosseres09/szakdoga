<?php

use common\components\AddressHelper;
use common\models\ShippingInformation;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
/**
 * @var View $this
 * @var ShippingInformation $shipping
 * @var ActiveForm $form
 */

$empty = AddressHelper::isEmpty($shipping);
?>

<h4 class="mt-3">Shipping Information</h4>
<div class="shippingContainer">
    <div class="shippingCheck <?= $empty ? 'd-none' : ''?>">
        <div class="shippingFormRaw">
            <span class="editIcon material-symbols-outlined">
                edit
            </span>
            <div class="address">
                <div class="row fw-bold">
                    <?= Html::encode($shipping->user->email) ?>
                </div>
                <div class="row">
                    <?= Html::encode($shipping->country) ?>,
                    <?= Html::encode($shipping->state) ?>
                </div>
                <div class="row text-muted">
                    <?= Html::encode($shipping->postcode) ?>
                    <?= Html::encode($shipping->city) ?>
                    <?= Html::encode($shipping->street) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="shippingForm <?= $empty ? '' : 'd-none' ?>">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <?= $form->field($shipping, 'country')->textInput(['maxlength' => 128, 'placeHolder' => 'Country'])->label(false) ?>
            </div>
            <div class="col-md-6 col-lg-4">
                <?= $form->field($shipping, 'state')->textInput(['maxlength' => 64, 'placeHolder' => 'State'])->label(false) ?>
            </div>
            <div class="col-md-12 col-lg-4">
                <?= $form->field($shipping, 'postcode')->textInput(['placeHolder' => 'Post Code'])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($shipping, 'city')->textInput(['maxlength' => 64, 'placeHolder' => 'City'])->label(false) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($shipping, 'street')->textInput(['maxlength' => 64, 'placeHolder' => 'Street'])->label(false) ?>
            </div>
        </div>
    </div>
</div>
