<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var LoginForm $user */

use common\models\LoginForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$fieldOptions = [
    'labelOptions' => ['class' => 'control-label'],
    'template' => '<div><span class="pb-5">{label}</span>{input}{hint}{error}</div>'
]
?>
<div class="container-fluid h-100" style="background-color: rgba(205,116,1,0.95)">
    <div class="container d-flex justify-content-center">
        <div class="site-signup">
            <div class="row">
                <h1 class="row text-center pb-2">
                    <a class="col" href="<?= Url::to(['/']) ?>">Sportify</a>
                    <span class="col">Login</span>
                </h1>
            </div>
            <div class="w-100 border-bottom"></div>
            <div class="row">
                <div class="col-sm-12">
                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                    <div class="row pt-3">
                        <?= $form->field($user, 'username', $fieldOptions)->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="row pt-2">
                        <?= $form->field($user, 'password', $fieldOptions)->passwordInput() ?>
                    </div>
                    <div class="row pt-2">
                        <?= $form->field($user, 'rememberMe', $fieldOptions)->checkbox() ?>
                    </div>
                    <div class="row pt-2">
                        <div class="col">
                            Don't have an account? <?= Html::a('Sign up', ['site/signup']) ?>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col">
                            <?= Html::a('Forgot your password?', ['site/request-password-reset']) ?>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="text-center">
                            <?= Html::submitButton('Login', ['class' => 'btn btn-primary text-white', 'name' => 'login-button']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!--<div class="container-fluid h-100" style="background-color: rgba(205, 116, 1, 0.95)">-->
<!--    <div class="container d-flex justify-content-center">-->
<!--        <div class="site-login">-->
<!--           <div class="row">-->
<!--               <h1 class="text-center pb-2">Sportify</h1>-->
<!--           </div>-->
<!--            <div class="w-100 border-bottom"></div>-->
<!--            <div class="row">-->
<!--                <div class="col-sm-12">-->
<!--                    --><?php //$form = ActiveForm::begin(['id' => 'login-form']); ?>
<!--                    <div class="row pt-3">-->
<!--                        --><?php //= $form->field($user, 'username', $fieldOptions)->textInput(['autofocus' => true]) ?>
<!--                    </div>-->
<!--                   <div class="row pt-2">-->
<!--                       --><?php //= $form->field($user, 'password', $fieldOptions)->passwordInput() ?>
<!--                   </div>-->
<!--                    <div class="row pt-2">-->
<!--                        --><?php //= $form->field($user, 'rememberMe', $fieldOptions)->checkbox() ?>
<!--                    </div>-->
<!--                    <div class="row pt-2">-->
<!--                        <div class="col">-->
<!--                            --><?php //= Html::a('Forgot your password?', ['site/request-password-reset']) ?>
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="row pt-2">-->
<!--                        <div class="col">-->
<!--                            Don't have an account? --><?php //= Html::a('Sign up', ['site/signup']) ?>
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="row pt-4">-->
<!--                        <div class="text-center">-->
<!--                            --><?php //= Html::submitButton('Login', ['class' => 'btn btn-primary text-white', 'name' => 'login-button']) ?>
<!--                        </div>-->
<!--                    </div>-->
<!--                    --><?php //ActiveForm::end(); ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
