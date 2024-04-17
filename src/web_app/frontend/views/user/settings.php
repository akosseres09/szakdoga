<?php
/**
 * @var View $this
 */

use yii\web\View;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Settings';

$user = Yii::$app->user->identity;

$this->registerCss(<<<CSS
    @media screen and (min-width: 992px){
        .border-md-end {
             border-right: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important;  
        }
    }
CSS);

?>

<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-7 pe-md-5 border-md-end">
                <?php $form = ActiveForm::begin([
                    'id' => 'user-update-form',
                    'action' => '/user/update',
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
            <div class="col-md-4 d-flex flex-column align-items-center mt-2 gap-3">
                <div>
                    <a class="btn btn-outline-dark" href="<?= Url::to(['/site/request-password-reset']) ?>">RESET PASSWORD</a>
                </div>
                <div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'user-delete-form',
                        'action' => Url::to(['/user/delete']),
                        'method' => 'POST'
                    ]) ?>
                    <?= $form->field($user, 'id')->hiddenInput()->label(false) ?>
                    <?= Html::submitButton('DELETE ACCOUNT', [
                            'class' => 'btn btn-outline-danger'
                    ]) ?>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>