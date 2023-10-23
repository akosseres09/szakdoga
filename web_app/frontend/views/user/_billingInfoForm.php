<?php
/**
 * @var BillingInformation $billingInfo
 * @var View $this
 */

use common\models\BillingInformation;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap5\ActiveForm;
?>

<div class="col-lg-5">
    <div class="p-1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Billing Information</h4>
        </div>
        <div class="row mt-3">
            <?php $form = ActiveForm::begin() ?>
            <div class="row">
                <div class="col-lg-6">
                    <?=
                        $form->field($billingInfo, 'country')
                            ->textInput(['placeholder' => 'Hungary', 'value' => $billingInfo->country ?: '' ]);
                    ?>
                </div>
                <div class="col-lg-6">
                   <?=
                        $form->field($billingInfo, 'state')
                            ->textInput(['placeholder' => 'Csongrád', 'value' => $billingInfo->state ?: '' ]);
                   ?>
                </div>
            </div>
            <div class="col-md-12">
                <?=
                    $form->field($billingInfo, 'city')
                        ->textInput(['placeholder' => 'City', 'value' => $billingInfo->city ?: '' ])
                ?>
            </div>
            <div class="col-md-12">
                <?=
                    $form->field($billingInfo, 'street')
                        ->textInput(['placeholder' => 'Tisza Lajos krt. 103', 'value' => $billingInfo->street ?: '' ])
                ?>
            </div>
            <div class="col-md-12">
                <?=
                    $form->field($billingInfo, 'postcode')
                        ->textInput(['type' => 'number','placeholder' => '6725', 'value' => $billingInfo->postcode ?: '' ])
                ?>
            </div>
        </div>
        <div class="mt-4 text-center">
            <?=
                Html::a('Save Billing Information', ['/user/save-billing/' . Yii::$app->user->id], [
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