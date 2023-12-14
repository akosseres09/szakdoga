<?php
/**
 * @var View $this
 * @var BillingInformation $billingInfo
 */

use common\models\BillingInformation;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$user = Yii::$app->user->getIdentity();
?>
<div class="col-lg-4">
    <div class="p-1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Billing Information</h4>
        </div>
            <?php $form = ActiveForm::begin([
                'id' => 'billing-info-form',
                'action' => '/user/save-billing'
            ]); ?>
            <div class="row justify-content-center">
                <?= $form->field($billingInfo, 'country')->textInput(['maxlength' => 128]) ?>
                <?= $form->field($billingInfo, 'state')->textInput(['maxlength' => 64]) ?>
                <?= $form->field($billingInfo, 'postcode')->textInput() ?>
                <?= $form->field($billingInfo, 'city')->textInput(['maxlength' => 64]) ?>
                <?= $form->field($billingInfo, 'street')->textInput(['maxlength' => 64]) ?>
                <div class="col-8">
                    <?= Html::submitButton('Update Billing Information', ['class' => 'btn btn-outline-light mt-2']) ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>
    </div>
</div>