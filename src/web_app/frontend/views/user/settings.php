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
            <div class="col-md-4 mt-md-0 mt-5 d-flex flex-column align-items-center mt-2 gap-3">
                <div>
                    <a class="btn btn-outline-dark" href="<?= Url::to(['/site/request-password-reset']) ?>">RESET PASSWORD</a>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        DEACTIVATE ACCOUNT
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#permaDeleteModal">
                        PERMANENTLY DELETE ACCOUNT
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin([
            'id' => 'DeleteModalForm',
            'action' => '/user/delete',
        ]) ?>
        <?= $form->field($user, 'id')->hiddenInput()->label(false) ?>
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="exampleModalLabel">Deactivate Account?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-break">
                <span class="h5 fw-normal">
                    Your account will be <span class="fw-bold text-danger">DEACTIVATED!</span><br>
                    If you wish to use this account after deactivation, you need to contact us!
                    <br>
                </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Deactivate</button>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>

<div class="modal fade" id="permaDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin([
            'id' => 'PermaDeleteModalForm',
            'action' => '/user/perma-delete',
        ]) ?>
        <?= $form->field($user, 'id')->hiddenInput()->label(false) ?>
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="exampleModalLabel">Delete Account?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-break">
                <span class="h5 fw-normal">
                    Your account will be <span class="fw-bold text-danger">DELETED!</span><br>
                    If you wish to use our site again, you would need to create a new account!
                    <br>
                </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>