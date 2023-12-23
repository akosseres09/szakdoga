<?php

/** @var View $this */
/** @var ActiveForm $form */
/** @var LoginForm $user */

use common\models\LoginForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Login';
$fieldOptions = [
'labelOptions' => ['class' => 'control-label'],
'template' => '<div><span class="pb-5">{label}</span>{input}{hint}{error}</div>'
]
?>
<div class="container-fluid h-100 new-container">
    <?= $this->render('/site/common/_alert') ?>
    <div class="container d-flex justify-content-center">
        <div class="site-signup">
            <div class="row">
                <h1 class="row text-center pb-2">
                    <a class="col-12" href="<?= Url::to(['/']) ?>">Sportify</a>
                    <span class="col-sm w-100 px-5">Admin Login</span>
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