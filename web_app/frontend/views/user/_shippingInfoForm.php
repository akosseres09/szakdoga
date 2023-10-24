<?php
/**
 * @var View $this
 * @var ShippingInformation $shippingInfo
 */

use common\models\ShippingInformation;

use yii\bootstrap5\ActiveForm;
use common\components\Html;
use yii\web\View;

$this->registerJsFile('@web/js/ShippingManager.js');
?>

<div id="shipping-container" class="col-lg-4">
    <div class="p-1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Shipping Information</h4>
            <span class="material-symbols-outlined write" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Shipping Info" style="cursor:pointer;">
                edit
            </span>
        </div>
        <div class="row mt-3">
            <?php $form = ActiveForm::begin() ?>
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <?=
                        $form->field($shippingInfo, 'country')
                            ->textInput(['placeholder' => 'Country','readonly' => true, 'value' => $shippingInfo->country?: '', 'class' => 'shipping form-control']);
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                        $form->field($shippingInfo, 'state')
                            ->textInput(['placeholder' => 'Csongrád','readonly' => true, 'value' => $shippingInfo->state?: '', 'class' => 'shipping form-control']);
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <?=
                    $form->field($shippingInfo, 'city')
                        ->textInput(['placeholder' => 'City','readonly' => true, 'value' => $shippingInfo->city ?: '','class' => 'shipping form-control']);
                ?>
            </div>
            <div class="col-md-12">
                <?=
                    $form->field($shippingInfo, 'street')
                        ->textInput(['placeholder' => 'Tisza Lajos krt. 103','readonly' => true, 'value' => $shippingInfo->street ?: '', 'class' => 'shipping form-control']);
                ?>
            </div>
            <div class="col-md-12">
                <?=
                    $form->field($shippingInfo, 'postcode')
                        ->textInput(['type' => 'number', 'readonly' => true, 'placeholder' => '6725', 'value' => $shippingInfo->postcode?: '', 'class' => 'shipping form-control']);
                ?>
            </div>
        </div>

        <div class="mt-4 text-center">
            <?=
                Html::a('Save Shipping Information', ['/user/save-shipping/'.Yii::$app->user->id],[
                    'class' => [
                        'btn btn-primary'
                    ],
                    'data' => [
                        'method' => 'post'
                    ]
                ])
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>