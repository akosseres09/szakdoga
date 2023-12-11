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
    'labelOptions' => ['class' => 'control-label'],
    'template' => '<div><span class="pb-5">{label}</span>{input}{hint}{error}</div>'
];

$this->title = 'Sportify >>> Signup';
?>
<div class="container-fluid h-100" style="background-color: rgba(205,116,1,0.95)">
    <div class="container d-flex justify-content-center">
        <div class="site-signup">
            <div class="row">
                <h1 class="row text-center pb-2">
                    <a class="col" href="<?= Url::to(['/']) ?>">Sportify</a>
                    <span class="col">Register</span>
                </h1>
            </div>
            <div class="w-100 border-bottom"></div>
            <div class="row">
                <div class="col-sm-12">
                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                    <div class="row pt-3">
                        <?= $form->field($model, 'username', $fieldOptions)->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="row pt-2">
                        <?= $form->field($model, 'email', $fieldOptions)->textInput(['maxlength' => 255]) ?>
                    </div>
                    <div class="row pt-2">
                        <?= $form->field($model, 'password', $fieldOptions)->passwordInput() ?>
                    </div>
                    <div class="row pt-2">
                        <?= $form->field($model, 'passwordAgain', $fieldOptions)->passwordInput() ?>
                    </div>
                    <div class="row pt-2">
                        <div class="col">
                            Already have an account? <?= Html::a('Log in', ['site/login']) ?>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="text-center">
                            <?= Html::submitButton('Signup', ['class' => 'btn btn-primary text-white', 'name' => 'signup-button']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
