<?php

/** @var View $this */
/** @var ActiveForm $form */
/** @var SignupForm $model */

use frontend\models\SignupForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap5\ActiveForm;

$fieldOptions = [
    'labelOptions' => ['class' => 'text-muted', 'style' => 'padding-left: 0.5rem'],
    'inputOptions' => ['class' => 'form-control custom-input'],
    'template' => '<div class="mb-3 form-floating">
                    {input}{label}{error}
                    </div>'
];

$this->title = 'Sportify » Signup';

$this->render('common/_alert');

?>
<div class="container-fluid h-100 new-container" >
    <div class="container d-flex justify-content-center">
        <div class="site-signup">
            <div class="row">
                <h1 class="row text-center">
                    <a class="col" href="<?= Url::to(['/']) ?>">Sportify</a>
                </h1>
                <h1 class="row text-center pb-2">
                    <span class="col">Register</span>
                </h1>
            </div>
            <div class="w-100 border-bottom"></div>
            <div class="row">
                <div class="col-sm-12">
                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                    <div class="row pt-3">
                        <?= $form->field($model, 'username', $fieldOptions)->textInput(['placeHolder' => 'Username']) ?>
                    </div>
                    <div class="row pt-2">
                        <?= $form->field($model, 'email', $fieldOptions)->textInput(['maxlength' => 255, 'type' => 'email', 'placeHolder' => 'Email']) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'password', $fieldOptions)->passwordInput(['placeHolder' => '']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'passwordAgain', $fieldOptions)->passwordInput(['placeHolder' => '']) ?>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col">
                            Already have an account? <?= Html::a('Log in', ['site/login']) ?>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="text-center">
                            <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
