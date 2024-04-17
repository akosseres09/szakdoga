<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var ResetPasswordForm $model */

use frontend\models\ResetPasswordForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->registerCss(<<<CSS
    .site-password-reset {
        min-width: 50%;
        max-width: 100%;
    }
    
    @media screen and (max-width: 480px){
        .site-password-reset {
            padding: 25px 30px;
        }
    }
CSS);

$this->title = 'Reset password';
?>
<div class="container-fluid new-container h-100">
    <div class="container d-flex justify-content-center">
        <div class="site-password-reset">
            <div class="row">
            <h1 class="text-center pb-2">
                <?= Html::encode($this->title) ?>
            </h1>

            </div>
            <div class="row pb-2">
                <p class="fs-5 text-center">Please choose your new password:</p>
            </div>
            <div class="w-100 border-bottom"></div>
            <div class="row d-flex justify-content-center pt-3">
                <div class="col-lg-10">
                    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                    <div class="row">
                        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
                    </div>
                    <div class="row">
                        <?= $form->field($model, 'rePassword')->passwordInput(['autofocus' => true]) ?>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-3 pt-4">
                        <div class="text-center">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <div class="text-center">
                            <?= Html::a('Cancel', Url::to(['/site/login']),['class' => ['btn btn-outline-dark cancel']]) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
