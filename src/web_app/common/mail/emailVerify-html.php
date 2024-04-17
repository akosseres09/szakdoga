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

<style>
    body {
        background-color: #fe9003;
    }
    h1 {
        font-size: 26px;
    }

    h5 {
        font-size: 20px;
    }

    .d-flex {
        display: flex;
    }

    .site-signup {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        padding: 20px 40px;
        display: flex;
        flex-direction: column;
        background-color: white;
        border-radius: 20px;
    }

    .text-center {
        text-align: center;
    }

    .btn {
        padding: 15px 30px;
        text-decoration: none;
        border-radius: 5px;
        color: black;
        background-color: transparent;
        transition: all 0.15s ease-in-out;
    }

    .btn.btn-outline-dark {
        border: 1px solid black;
    }

    .btn.btn-outline-dark:hover {
        background-color: black;
        color: white;
    }

    .link-span {
        justify-content: center;
    }
</style>

<div class="site-signup">
    <div class="container">
        <h1 class="text-center">
            Welcome To Sportify <?= $user->username ?>!
        </h1>
        <h5 class="text-center">
            Please Verify Your Email to be able to use your account!
        </h5>
        <span class="d-flex link-span text-center">
            <a class="btn btn-outline-dark" href="<?= Html::encode($verifyLink)?>">VERIFY EMAIL</a>
        </span>
    </div>
</div>

