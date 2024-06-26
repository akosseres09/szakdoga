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
    'template' => '<div><span class="pb-5">{label}</span>{input}{error}</div>'
];
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
?>
<div class="container-fluid h-100 new-container" >
    <div class="container d-flex justify-content-center">
        <div class="site-password-reset">
            <div class="row">
                <h1 class="row text-center pb-2">
                    <a class="col" href="<?= Url::to(['/']) ?>">Sportify</a>
                </h1>
                <div class="col text-center pb-3">
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
                            <?php if(Yii::$app->user->isGuest) { ?>
                                <?= Html::a('Cancel', Url::to(['/site/login']),['class' => ['btn btn-outline-dark cancel']]) ?>
                            <?php } else { ?>
                                <?= Html::a('Cancel', Url::to(Yii::$app->request->referrer),['class' => ['btn btn-outline-dark cancel']]) ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
