<?php
/**
 * @var View $this
 */

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

Yii::$app->name = 'Sportify';

$actionName = Yii::$app->controller->action->id;

?>
<nav id="mobile-header" class="d-none navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= Url::to(['/shop/products'])?>"><?= Yii::$app->name?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav me-auto px-3">
            <div class="mobile-nav nav-item dropdown">
               <a class="nav-link justify-content-start">
                   Products
               </a>
                <div class="px-3 drop" aria-labelledby="navbarDropdown">
                    <span>
                        <a class="p-1 dropdown-item" href="<?= Url::to(['/shop?gender='. Product::GENDER_MALE]) ?>">
                            Men
                        </a>
                    </span>
                    <span>
                        <a class="p-1 dropdown-item" href="<?= Url::to(['/shop?gender='. Product::GENDER_FEMALE]) ?>">
                            Women
                        </a>
                    </span>
                </div>
            </div>
            <div class="mobile-nav nav-item dropdown">
                <a class="nav-link justify-content-start" href="<?= Url::to(['/shop?type=&type%5B%5D=Gloves']) ?>">
                    Gloves
                </a>
            </div>
            <?php if(Yii::$app->user->isGuest) { ?>
                <?php if ($actionName !== 'login') { ?>
                    <div class="nav-item">
                        <a class="nav-link justify-content-start" href="<?= Url::to(['/site/login'])?>">Login</a>
                    </div>
                <?php } ?>
                <?php if ($actionName !== 'signup') { ?>
                    <div class="nav-item">
                        <a class="nav-link justify-content-start" href="<?= Url::to(['/site/signup']) ?>">Sign up</a>
                    </div>
                <?php } ?>
            <?php } else {?>
                <div class="nav-item">
                    <a class="nav-link justify-content-start" aria-current="page" href="<?= Url::to(['/cart/cart']) ?>">
                        Cart
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link justify-content-start" aria-current="page" href="<?= Url::to(['/wishlist']) ?>">
                        Wishlist
                    </a>
                </div>
                <div class="mobile-nav nav-item dropdown">
                    <a class="nav-link justify-content-start" href="#">
                        Profile
                    </a>
                    <div class="px-3 drop" aria-labelledby="navbarDropdown">
                        <span>
                           <a class="dropdown-item p-1" href="<?= Url::to(['/account']) ?>">Account</a></span>
                        <span>
                            <a class="dropdown-item p-1" href="<?= Url::to(['/settings']) ?>">Settings</a></span>
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
            <?php } ?>
        </div>
    </div>
</nav>


<nav id="desktop-header" class="shop-nav navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="container">
            <div class="navbar-collapse d-flex justify-content-evenly" id="navbarSupportedContent">
                <a class="navbar-brand" href="<?= Url::to(['/shop/products'])?>"><?= Yii::$app->name?></a>
                <div class="navbar-nav me-auto mb-2 mb-lg-0 d-flex gap-2 flex-1">
                    <div class="d-flex gap-3 align-items-center flex-1">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Products
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item sub" href="<?= Url::to(['/shop?gender=&gender%5B%5D=0']) ?>">Men</a>
                                    <ul class="submenu dropdown-menu">
                                        <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=0&type=&type%5B%5D=Shirt']) ?>">Shirt</a></li>
                                        <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=0&type=&type%5B%5D=Accessories']) ?>">Accessories</a></li>
                                        <li class="dropdown-item sub">
                                            <a href="<?= Url::to(['/shop?gender=&gender%5B%5D=0&type=&type%5B%5D=Basketball+Shoes&type%5B%5D=Handball+Shoes&type%5B%5D=Indoor+Football+Shoes&type%5B%5D=Outdoor+Football+Shoes&type%5B%5D=Shoes']) ?>">Shoes</a>
                                            <ul class="submenu dropdown-menu">
                                                <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=0&type=&type%5B%5D=Indoor Football Shoes']) ?>">Indoor Football Shoes</a></li>
                                                <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=0&type=&type%5B%5D=Outdoor Football Shoes']) ?>">Outdoor Football Shoes</a></li>
                                                <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=0&type=&type%5B%5D=Basketball Shoes']) ?>">Basketball Shoes</a></li>
                                                <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=0&type=&type%5B%5D=handball Shoes']) ?>">Handball Shoes</a></li>
                                                <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=0&type=&type%5B%5D=Shoes']) ?>">Shoes</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>
                                <li>
                                    <a class="dropdown-item sub" href="<?= Url::to(['/shop?gender=&gender%5B%5D=1']) ?>">Women</a>
                                    <ul class="submenu dropdown-menu">
                                        <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=1&type=&type%5B%5D=Shirt']) ?>">Shirt</a></li>
                                        <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=1&type=&type%5B%5D=Accessories']) ?>">Accessories</a></li>
                                        <li class="dropdown-item sub">
                                            <a href="<?= Url::to(['/shop?gender=&gender%5B%5D=1&type=&type%5B%5D=Basketball+Shoes&type%5B%5D=Handball+Shoes&type%5B%5D=Indoor+Football+Shoes&type%5B%5D=Outdoor+Football+Shoes&type%5B%5D=Shoes']) ?>">Shoes</a>
                                            <ul class="dropdown-menu submenu">
                                                <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=1&type=&type%5B%5D=Indoor Football Shoes']) ?>">Indoor Football Shoes</a></li>
                                                <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=1&type=&type%5B%5D=Outdoor Football Shoes']) ?>">Outdoor Football Shoes</a></li>
                                                <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=1&type=&type%5B%5D=Basketball Shoes']) ?>">Basketball Shoes</a></li>
                                                <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=1&type=&type%5B%5D=handball Shoes']) ?>">Handball Shoes</a></li>
                                                <li class="dropdown-item"><a href="<?= Url::to(['/shop?gender=&gender%5B%5D=1&type=&type%5B%5D=Shoes']) ?>">Shoes</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['/shop?type=&type%5B%5D=Gloves']) ?>" id="navbarDropdown">
                                Gloves
                            </a>
                        </div>
                    </div>
                    <?php if(Yii::$app->user->isGuest): ?>
                        <div class="d-flex gap-3 me-5">
                            <?php if ($actionName !== 'login'): ?>
                                <div class="nav-item">
                                    <a class="btn btn-outline-dark" href="<?= Url::to(['/site/login'])?>">Login</a>
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
                                <a class="nav-link" href="<?= Url::to(['/cart/cart']) ?>">
                                <span class="material-symbols-outlined">
                                    shopping_cart
                                </span>
                                </a>
                                <span id="cartCount" class="position-absolute translate-middle badge rounded-pill" style="background-color: var(--spfy-main-color); top: 25%; left: 90%">
                                    <?= Yii::$app->user->identity->getCartCount() ?>
                                </span>
                            </div>
                            <div class="nav-item align-self-center position-relative">
                                <a class="nav-link" href="<?= Url::to(['/wishlist']) ?>">
                                    <span class="material-symbols-outlined">
                                        favorite
                                    </span>
                                </a>
                                <span id="wishListCount" class="position-absolute translate-middle badge rounded-pill" style="background-color: var(--spfy-main-color); top: 25%; left: 90%">
                                    <?= Yii::$app->user->identity->getWishlistCount() ?>
                                </span>
                            </div>
                            <div class="nav-item dropdown" id="profile" style="padding-right: 30px">
                                <a class="nav-link dropdown-toggle d-flex" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">account_circle</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="transform: translateX(-50%)">
                                    <a class="dropdown-item" href="<?= Url::to(['/account']) ?>">Account</a>
                                    <a class="dropdown-item" href="<?= Url::to(['/settings']) ?>">Settings</a>
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