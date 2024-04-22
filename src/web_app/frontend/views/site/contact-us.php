<?php
/**
 * @var View $this
 * @var ContactForm $contactForm
 */

use common\components\Html;
use frontend\models\ContactForm;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\web\View;

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
$this->title = 'Contact Us';
$email = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->email;
?>

<div class="container-fluid h-100 new-container" >
    <?= $this->render('/site/common/_alert'); ?>
    <div class="container d-flex justify-content-center">
        <div class="site-password-reset">
            <div class="row">
                <h1 class="row text-center pb-2">
                    <a class="col" href="<?= Url::to(['/']) ?>">Sportify</a>
                    <span>Contact Us</span>
                </h1>
                <div class="col text-center pb-3">
                </div>
            </div>
            <div class="w-100 border-bottom"></div>
            <div class="row">
                <div class="col-sm-12">
                    <?php $form = ActiveForm::begin(['id' => 'form-password-reset']); ?>
                    <div class="row pt-3">
                        <?= $form->field($contactForm, 'email', $fieldOptions)->textInput(['type' => 'email', 'required' => true, 'value' => $email]) ?>
                    </div>
                    <div class="row pt-3">
                        <?= $form->field($contactForm, 'subject', $fieldOptions)->textInput(['required' => true]) ?>
                    </div>
                    <div class="row pt-3">
                        <?= $form->field($contactForm, 'body', $fieldOptions)->textarea(['required' => true]) ?>
                    </div>
                    <div class="row pt-3">
                        <?= $form->field($contactForm, 'captcha', $fieldOptions)->widget(Captcha::class, [
                                'template' => '<div class="row"><span class="col-sm-8 d-flex align-items-center">{input}</span><span class="col-sm-4 mt-2 mt-sm-0">{image}</span></div>',
                        ]) ?>
                    </div>
                    <div class="pt-4">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <?= Html::submitButton('Send', ['class' => 'w-100 btn btn-primary']) ?>
                            </div>
                            <div class="col-md-6 pt-md-0 pt-2 text-center">
                                <?php if(Yii::$app->user->isGuest) { ?>
                                    <?= Html::a('Cancel', Url::to(['/site/login']),['class' => ['w-100 btn btn-outline-dark cancel']]) ?>
                                <?php } else { ?>
                                    <?= Html::a('Cancel', Url::to(Yii::$app->request->referrer ?? Url::to(['/'])),
                                        [
                                            'class' => [
                                                'w-100 btn btn-outline-dark cancel'
                                            ]
                                        ])
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>