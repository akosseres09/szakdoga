<?php
/**
 * @var View $this
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

Yii::$app->name = 'Sportify';

$actionName = Yii::$app->controller->action->id;

?>
<nav id="mobile-header" class="d-none navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= Url::to(['/'])?>"><?= Yii::$app->name?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav me-auto px-3">
            <div>
                <div class="mobile-nav nav-item dropdown">
                    <a class="nav-link justify-content-start" href="#">
                        Products
                    </a>
                    <div class="px-3 drop" aria-labelledby="navbarDropdown">
                        <span>
                            <a class="p-1 dropdown-item" href="#">Shoes</a>
                        </span>
                        <span>
                            <a class="p-1 dropdown-item" href="#">Balls</a>
                        </span>
                        <span>
                            <a class="p-1 dropdown-item" href="#">Accessories</a>
                        </span>
                        <span>
                            <a class="p-1 dropdown-item" href="#">Clothes</a>
                        </span>
                    </div>
                </div>
                <div class="mobile-nav nav-item dropdown">
                    <a class="nav-link justify-content-start" href="#">
                        Info
                    </a>
                    <div class="px-3 drop" aria-labelledby="navbarDropdown">
                        <span><a class="p-1 dropdown-item" href="<?= Url::to(['/site/contact']) ?>">Contact</a></span>
                        <span><a class="p-1 dropdown-item" href="#">Another action</a></span>
                        <span><a class="p-1 dropdown-item" href="#">Something else here</a></span>
                    </div>
                </div>
                <?php if(Yii::$app->user->isGuest): ?>
                    <?php if ($actionName !== 'login'): ?>
                        <div class="nav-item">
                            <a class="nav-link justify-content-start" href="<?= Url::to(['/site/login'])?>">Login</a>
                        </div>
                    <?php endif; ?>
                    <?php if ($actionName !== 'signup') : ?>
                        <div class="nav-item">
                            <a class="nav-link justify-content-start" href="<?= Url::to(['/site/signup']) ?>">Sign up</a>
                        </div>
                    <?php endif; ?>
                <?php else :?>
                    <div class="nav-item">
                        <a class="nav-link justify-content-start" aria-current="page" href="#">
                            Cart
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link justify-content-start" aria-current="page" href="#">
                            Wishlist
                        </a>
                    </div>
                    <div class="mobile-nav nav-item dropdown">
                        <a class="nav-link justify-content-start" href="#">
                            Profile
                        </a>
                        <div class="px-3 drop" aria-labelledby="navbarDropdown">
                           <span><a class="dropdown-item p-1" href="<?= Url::to(['/user/account']) ?>">Account</a></span>
                            <span><a class="dropdown-item p-1" href="<?= Url::to(['/user/settings']) ?>">Settings</a></span>
                           <span>
                                <?= Html::a('Logout', ['/site/logout'], [
                                    'class' => 'dropdown-item p-1',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]);
                                ?>
                           </span>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</nav>


<nav id="desktop-header" class="shop-nav navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="container">
            <div class="navbar-collapse d-flex justify-content-evenly" id="navbarSupportedContent">
            <a class="navbar-brand" href="<?= Url::to(['/'])?>"><?= Yii::$app->name?></a>
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
                                <li  class="dropdown-item"><a href="<?= Url::to(['/site/contact']) ?>">Contact</a></li>
                                <li  class="dropdown-item"><a href="#">Another action</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li  class="dropdown-item"><a href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php if(Yii::$app->user->isGuest): ?>
                        <div class="d-flex gap-3 me-5">
                            <?php if ($actionName !== 'login'): ?>
                                <div class="nav-item">
                                    <a class="btn btn-outline-light" href="<?= Url::to(['/site/login'])?>">Login</a>
                                </div>
                            <?php endif; ?>
                            <?php if ($actionName !== 'signup'): ?>
                                <div class="nav-item">
                                    <a class="btn btn-primary" href="<?= Url::to(['/site/signup']) ?>">Sign up</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else :?>
                        <div class="d-flex gap-3">
                            <div class="nav-item position-relative">
                                <a class="nav-link" href="#">
                                <span class="material-symbols-outlined">
                                    shopping_cart
                                </span>
                                </a>
                                <span class="position-absolute translate-middle badge rounded-pill" style="background-color: var(--spfy-main-color); top: 25%; left: 90%">
                               <?= Yii::$app->user->getIdentity()->getCartCount() ?>
                            </span>
                            </div>
                            <div class="nav-item align-self-center">
                                <a class="nav-link" href="#">
                                <span class="material-symbols-outlined">
                                    favorite
                                </span>
                                </a>
                            </div>
                            <div class="nav-item dropdown" id="profile" style="padding-right: 30px">
                                <a class="nav-link dropdown-toggle d-flex" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">account_circle</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="transform: translateX(-50%)">
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
            </div>
        </div>
    </div>
</nav>