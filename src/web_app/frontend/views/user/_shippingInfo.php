<?php

use common\models\ShippingInformation;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
/**
 * @var View $this
 * @var ShippingInformation $shippingInfo
 */

$user = Yii::$app->user->getIdentity();
?>
<div class="col-lg-4 pt-5 pt-lg-0">
    <div class="p-1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Shipping Information</h4>
        </div>
        <?php $form = ActiveForm::begin([
            'id' => 'shipping-info-form',
            'action' => '/user/save-shipping'
        ]); ?>
        <div class="row justify-content-center">
            <?= $form->field($shippingInfo, 'country')->textInput(['maxlength' => 128]) ?>
            <?= $form->field($shippingInfo, 'state')->textInput(['maxlength' => 64]) ?>
            <?= $form->field($shippingInfo, 'postcode')->textInput() ?>
            <?= $form->field($shippingInfo, 'city')->textInput(['maxlength' => 64]) ?>
            <?= $form->field($shippingInfo, 'street')->textInput(['maxlength' => 64]) ?>
            <div class="col-auto d-flex justify-content-center">
                <?= Html::submitButton('Update Shipping Information', ['class' => 'btn btn-outline-dark mt-2']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>