<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */

use frontend\assets\LandingAsset;
use yii\helpers\Url;

$this->beginContent('@frontend/views/layouts/base.php');
LandingAsset::register($this);
?>
<header id="header">
    <nav id="mobile-header" class="d-none navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">Sportify</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-nav me-auto px-3">
                <?php if(Yii::$app->user->isGuest): ?>
                        <div class="nav-item">
                            <a class="nav-link justify-content-start" href="<?= Url::to(['/site/login'])?>">Login</a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link justify-content-start" href="<?= Url::to(['/site/signup']) ?>">Sign up</a>
                        </div>
                <?php else :?>
                    <div class="nav-item">
                        <a class="nav-link justify-content-start" aria-current="page" href="#">
                            Browse Products
                        </a>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </nav>
    <nav id="desktop-header" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="container">
                <div class="navbar-collapse d-flex justify-content-evenly" id="navbarSupportedContent">
                    <span class="navbar-brand fw-bold">Sportify</span>
                    <div class="navbar-nav me-auto mb-2 mb-lg-0 d-flex gap-2 flex-1">
                        <div class="d-flex gap-3 align-items-center flex-1">
                            <?php if(Yii::$app->user->isGuest): ?>
                                <div class="d-flex gap-3 ms-auto">
                                    <a class="btn btn-secondary" href="<?= Url::to(['/site/login']) ?>">
                                        Log in
                                    </a>
                                    <a class="btn btn-primary" href="<?= Url::to(['/site/signup']) ?>">
                                        Sign up
                                    </a>
                                </div>
                            <?php else :?>
                                <div class="d-flex gap-3 ms-auto">
                                    <a class="btn btn-primary">Browse Products</a>
                                    <a href="<?= Url::to(['site/logout'])?>" data-method="POST" class="btn btn-secondary">Log out</a>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<?= $content ?>
<?php $this->endContent(); ?>


