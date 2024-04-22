<?php
/**
 * @var View $this
 * @var ContactForm $form
 */

use frontend\models\ContactForm;
use yii\web\View;

$this->registerCss(<<<CSS
    .container .row {
        margin-left: 0;
    }

    .email-container {
        padding: 0 50px;
    }
CSS);

?>

<div class="container-fluid">
    <div class="container">
        <div class="email-container">
            <h1 class="row mt-5 text-center">Contact was Made by: <?= $form->email ?>! </h1>
            <div class="row h4 mt-5">
                Subject: <?= $form->subject ?>
            </div>
            <div class="mt-3">
            <span>
                Body:
            </span>
                <div class=" px-4 py-2">
                    <?= htmlspecialchars($form->body) ?>
                </div>
            </div>
        </div>
    </div>
</div>
