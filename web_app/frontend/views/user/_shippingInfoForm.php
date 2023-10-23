<?php
/**
 * @var ShippingInformation $shippingInfo
 */

use common\models\ShippingInformation;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
?>

<div class="col-lg">
    <div class="p-1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Shipping Information</h4>
        </div>
        <div class="row mt-3">
            <?php $form = ActiveForm::begin() ?>
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <?=
                        $form->field($shippingInfo, 'country')
                            ->textInput(['placeholder' => 'Country', 'value' => $shippingInfo->country?: '']);
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                        $form->field($shippingInfo, 'state')
                            ->textInput(['placeholder' => 'Csongrád', 'value' => $shippingInfo->state?: '']);
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <?=
                    $form->field($shippingInfo, 'city')
                        ->textInput(['placeholder' => 'City', 'value' => $shippingInfo->city ?: '']);
                ?>
            </div>
            <div class="col-md-12">
                <?=
                    $form->field($shippingInfo, 'street')
                        ->textInput(['placeholder' => 'Tisza Lajos krt. 103', 'value' => $shippingInfo->street ?: '']);
                ?>
            </div>
            <div class="col-md-12">
                <?=
                    $form->field($shippingInfo, 'postcode')
                        ->textInput(['type' => 'number', 'placeholder' => '6725', 'value' => $shippingInfo->postcode?: '']);
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