<?php
/**
 * @var BillingInformation $billing
 * @var View $this
 * @var ActiveForm $form
 */

use common\models\BillingInformation;
use yii\web\View;
use yii\widgets\ActiveForm;

?>

<h4>Billing Information</h4>
<div class="billingContainer">
    <div class="billingCheck">
        <div class="billingFormRaw">
            <span class="editIcon material-symbols-outlined">
                edit
            </span>
            <div class="address">
                <div class="row fw-bold">
                    <?= $billing->user->email ?>
                </div>
                <div class="row">
                    <?= $billing->country ?>,
                    <?= $billing->state ?>
                </div>
                <div class="row text-muted">
                    <?= $billing->postcode ?>
                    <?= $billing->city ?>
                    <?= $billing->street ?>
                </div>
            </div>
        </div>
    </div>
    <div class="billingForm d-none">
        <div class="row">
            <div class="col">
                <?= $form->field($billing, 'country')->textInput(['maxlength' => 128, 'placeHolder' => 'Country'])->label(false) ?>
            </div>
            <div class="col">
                <?= $form->field($billing, 'state')->textInput(['maxlength' => 64, 'placeHolder' => 'State'])->label(false) ?>
            </div>
            <div class="col">
                <?= $form->field($billing, 'postcode')->textInput(['placeHolder' => 'Post Code'])->label(false) ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <?= $form->field($billing, 'city')->textInput(['maxlength' => 64, 'placeHolder' => 'City'])->label(false) ?>
            </div>
            <div class="col">
                <?= $form->field($billing, 'street')->textInput(['maxlength' => 64, 'placeHolder' => 'Street'])->label(false) ?>
            </div>
        </div>
    </div>
</div>

