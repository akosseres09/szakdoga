<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var ContactForm $model */

use frontend\models\ContactForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Contact';
?>
<div class="site-contact mt-3">
    <div class="row">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="col-10">
                <h1><?= Html::encode($this->title) ?></h1>
                <p>
                    If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
                </p>
            </div>
            <div class="col-10">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>
