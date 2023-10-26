<?php
/**
 * @var BillingInformation $billingInfo
 * @var View $this
 */

use common\models\BillingInformation;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap5\ActiveForm;

$this->title = 'Edit your Billing Information';
?>

<div class="col-sm-12">
    <div class="p-1 mt-3">
        <div class="d-flex justify-content-center align-items-center mb-3">
            <h4 class="text-right">Billing Information</h4>
        </div>
        <?php $form = ActiveForm::begin() ?>
        <div class="row mt-3">
            <div class="row">
                <?=
                    $form->field($billingInfo, 'country')
                        ->textInput(['placeholder' => 'Hungary', 'value' => $billingInfo->country ?: '' ]);
                ?>
            </div>
            <div>
                <?=
                $form->field($billingInfo, 'state')
                    ->textInput(['placeholder' => 'Csongrád', 'value' => $billingInfo->state ?: '' ]);
                ?>
            </div>
            <div>
                <?=
                    $form->field($billingInfo, 'city')
                        ->textInput(['placeholder' => 'City', 'value' => $billingInfo->city ?: '' ])
                ?>
            </div>
            <div>
                <?=
                    $form->field($billingInfo, 'street')
                        ->textInput(['placeholder' => 'Tisza Lajos krt. 103', 'value' => $billingInfo->street ?: '' ])
                ?>
            </div>
            <div>
                <?=
                    $form->field($billingInfo, 'postcode')
                        ->textInput(['type' => 'number','placeholder' => '6725', 'value' => $billingInfo->postcode ?: '' ])
                ?>
            </div>
        </div>
        <div class=" mt-4 text-center">
            <?=
            Html::a('Save Billing Information', ['/user/save-billing'], [
                'class' => [
                    'btn btn-primary'
                ],
                'data' => [
                    'method' => 'post'
                ]
            ]);
            ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>