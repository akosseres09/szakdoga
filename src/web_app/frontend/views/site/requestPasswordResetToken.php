<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var PasswordResetRequestForm $model */

use frontend\models\PasswordResetRequestForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Sportify » Request password reset';
$fieldOptions = [
    'labelOptions' => ['class' => 'control-label'],
    'template' => '<div><span class="pb-5">{label}</span>{input}{hint}{error}</div>'
];

?>
<div class="container-fluid h-100 new-container" >
    <div class="container d-flex justify-content-center">
        <div class="site-password-reset">
            <div class="row">
                <h1 class="row text-center pb-2">
                    <a class="col" href="<?= Url::to(['/']) ?>">Sportify</a>
                </h1>
                <div class="col text-center pb-3">
                    <span class="text-center fs-5"> If you do not remember your password, <br>please give your email address to reset it. </span>
                </div>
            </div>
            <div class="w-100 border-bottom"></div>
            <div class="row">
                <div class="col-sm-12">
                    <?php $form = ActiveForm::begin(['id' => 'form-password-reset']); ?>
                    <div class="row pt-3">
                        <?= $form->field($model, 'email', $fieldOptions)->textInput(['type' => 'email']) ?>
                    </div>
                    <div class="pt-4 d-flex justify-content-center align-items-center gap-3">
                        <div class="text-center">
                            <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <div class="text-center">
                            <?= Html::a('Cancel', Url::to(['/site/login']),['class' => ['btn btn-outline-dark cancel']]) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
