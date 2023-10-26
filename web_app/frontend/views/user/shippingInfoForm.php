<?php
/**
 * @var View $this
 * @var ShippingInformation $shippingInfo
 */

use common\models\ShippingInformation;
use yii\bootstrap5\ActiveForm;
use common\components\Html;
use yii\web\View;

$this->title = 'Edit Your Shipping Information';
?>

<div id="shipping-container" class="col-sm-12">
    <div class="px-3 mt-3">
        <div class="d-flex justify-content-center align-items-center mb-3">
            <h4 class="text-right">Shipping Information</h4>
        </div>
        <?php $form = ActiveForm::begin() ?>
        <div class="row mt-3">
            <div class="row justify-content-between">
                <?=
                    $form->field($shippingInfo, 'country')
                        ->textInput(['placeholder' => 'Country', 'value' => $shippingInfo->country?: '']);
                ?>
            </div>
            <div>
                <?=
                $form->field($shippingInfo, 'state')
                    ->textInput(['placeholder' => 'Csongrád', 'value' => $shippingInfo->state?: '']);
                ?>
            </div>
            <div>
                <?=
                    $form->field($shippingInfo, 'city')
                        ->textInput(['placeholder' => 'City', 'value' => $shippingInfo->city ?: '']);
                ?>
            </div>
            <div>
                <?=
                    $form->field($shippingInfo, 'street')
                        ->textInput(['placeholder' => 'Tisza Lajos krt. 103', 'value' => $shippingInfo->street ?: '']);
                ?>
            </div>
            <div>
                <?=
                    $form->field($shippingInfo, 'postcode')
                        ->textInput(['type' => 'number', 'placeholder' => '6725', 'value' => $shippingInfo->postcode?: '']);
                ?>
            </div>
        </div>
        <div class="mt-4 text-center">
            <?=
                Html::a('Save Shipping Information', ['/user/save-shipping'],[
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