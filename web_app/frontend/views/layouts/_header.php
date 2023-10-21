<?php
/**
 * @var View $this
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

Yii::$app->name = 'Webshop';
$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js', ['position' => View::POS_END]);
$this->registerCssFile('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
?>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= Url::to(['/'])?>"><?= Yii::$app->name?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-evenly" id="navbarSupportedContent">
            <div class="navbar-nav me-auto mb-2 mb-lg-0 d-flex gap-2 flex-1">
                <div class="d-flex gap-3 align-items-center flex-1">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="dropdown-item"><a>Shoes</a></li>
                            <li class="dropdown-item"><a>Balls</a></li>
                            <li class="dropdown-item"><a>Accessories</a></li>
                            <li class="dropdown-item"><a>Clothes</a></li>
                        </ul>
                    </div>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Info
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= Url::to(['/site/contact']) ?>">Contact</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <?php if(Yii::$app->user->isGuest): ?>
                    <div class="d-flex gap-3">
                        <div class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['/site/login'])?>">Login</a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['/site/signup']) ?>">Sign up</a>
                        </div>
                    </div>
<!--                --><?php else :?>
                    <div class="d-flex gap-3">
                        <div class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="material-symbols-outlined">
                                    shopping_cart
                                </span>
                            </a>
                        </div>
                        <div class="nav-item dropdown" id="profile" style="padding-right: 30px">
                            <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">account_circle</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="transform: translateX(-30%)">
                                <a class="dropdown-item" href="<?= Url::to(['/user/account']) ?>">Account</a>
                                <a class="dropdown-item" href="<?= Url::to(['/user/settings']) ?>">Settings</a>
                                <?= Html::a('Logout', ['/site/logout'], [
                                    'class' => 'dropdown-item',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <ul>

            </ul>
<!--            <form class="d-flex">-->
<!--                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
<!--                <button class="btn btn-outline-success" type="submit">Search</button>-->
<!--            </form>-->
        </div>
    </div>
</nav>