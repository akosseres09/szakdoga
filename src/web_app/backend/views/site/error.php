<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Url;

$this->title = $name;

?>
<div class="error-container container-fluid h-100" style="background-color: var(--spfy-primary-light)">
    <div class="container py-5" style="background-color: white; border-radius: 50px">
        <div class="w-100 text-center">
            <div class="site-error">
                <div class="row">
                    <h1 style="font-size: 100px;"><?= $exception->statusCode ?></h1>
                </div>
                <div class="row mt-2">
                    <h4>
                        <?= $message ?>
                    </h4>
                </div>
                <div class="row mt-2">
                    <span class="fs-5">
                        It looks like you're lost! <br>
                        Please return to the homepage.
                    </span>
                </div>
                <div class="mt-4">
                    <a class="btn btn-outline-dark fs-5" href="<?= Url::to(['/']) ?>">
                        BACK TO HOMEPAGE
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
