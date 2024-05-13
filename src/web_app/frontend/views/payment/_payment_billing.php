<?php
/**
 * @var BillingInformation $billing
 * @var View $this
 * @var ActiveForm $form
 */

use common\components\AddressHelper;
use common\models\BillingInformation;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$empty = AddressHelper::isEmpty($billing);
?>

<h4>Billing Information</h4>
<div class="billingContainer">
    <div class="billingCheck <?= $empty ? 'd-none' : '' ?>">
        <div class="billingFormRaw">
        <span class="editIcon material-symbols-outlined">
            edit
        </span>
            <div class="address">
                <div class="row fw-bold">
                    <?= Html::encode($billing->user->email) ?>
                </div>
                <div class="row">
                    <?= Html::encode($billing->country) ?>,
                    <?= Html::encode($billing->state) ?>
                </div>
                <div class="row text-muted">
                    <?= Html::encode($billing->postcode) ?>
                    <?= Html::encode($billing->city) ?>
                    <?= Html::encode($billing->street) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="billingForm <?= $empty ? '' : 'd-none' ?>">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <?= $form->field($billing, 'country')->textInput(['maxlength' => 128, 'placeHolder' => 'Country'])->label(false) ?>
            </div>
            <div class="col-md-6 col-lg-4">
                <?= $form->field($billing, 'state')->textInput(['maxlength' => 64, 'placeHolder' => 'State'])->label(false) ?>
            </div>
            <div class="col-md-12 col-lg-4">
                <?= $form->field($billing, 'postcode')->textInput(['placeHolder' => 'Post Code'])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($billing, 'city')->textInput(['maxlength' => 64, 'placeHolder' => 'City'])->label(false) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($billing, 'street')->textInput(['maxlength' => 64, 'placeHolder' => 'Street'])->label(false) ?>
            </div>
        </div>
    </div>
</div>

