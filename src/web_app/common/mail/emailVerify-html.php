<?php

use common\models\User;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var User $user
 */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>

<div class="container-fluid mt-5">
    <div class="container d-flex flex-column align-items-center justify-content-center">
        <h1 class="row mb-3">
            Welcome To Sportify <?= $user->username ?>!
        </h1>
        <h5 class="row mb-3">
            Please verify your email to be able to use your account!
        </h5>
        <div class="row">
            <div class="col">
                <a class="btn btn-outline-dark" href="<?= Html::encode($verifyLink)?>">VERIFY EMAIL</a>
            </div>
        </div>
    </div>
</div>

