<?php
/**
 * @var View $this
 */

use yii\base\View;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Settings';

$user = Yii::$app->user->identity;
?>

<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <?php $form = ActiveForm::begin([
                    'id' => 'user-update-form',
                    'action' => '/user/update',
                    'enableAjaxValidation' => true
                ]) ?>
                <?= $form->field($user, 'email')->textInput(['required', 'maxLength']) ?>
                <?= $form->field($user, 'username')->textInput(['required', 'maxLength']) ?>
                <div class="text-center">
                    <?= Html::submitButton('Update', [
                        'class' => 'btn btn-primary'
                    ]) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>