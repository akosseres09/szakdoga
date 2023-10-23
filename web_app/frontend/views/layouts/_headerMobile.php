<?php use yii\helpers\Html;
use yii\helpers\Url;
Yii::$app->name = 'Webshop';
?>

<nav id="mobile-header" class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= Url::to(['/'])?>"><?= Yii::$app->name?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse d-flex justify-content-evenly" id="navbarSupportedContent">
        <div class="navbar-nav me-auto px-3">
            <div>
                <div class="mobile-nav nav-item">
                    <a class="nav-link justify-content-start" aria-current="page" href="#">
                        Products</a>
                    <div class="px-3" aria-labelledby="navbarDropdown">
                        <span class="p-1 dropdown-item"><a>Shoes</a></span>
                        <span class=" p-1 dropdown-item"><a>Balls</a></span>
                        <span class="p-1 dropdown-item"><a>Accessories</a></span>
                        <span class="p-1 dropdown-item"><a>Clothes</a></span>
                    </div>
                </div>
                <div class="mobile-nav nav-item dropdown">
                    <a class="nav-link justify-content-start" href="#">
                        Info
                    </a>
                    <div class="px-3" aria-labelledby="navbarDropdown">
                        <span><a class="p-1 dropdown-item" href="<?= Url::to(['/site/contact']) ?>">Contact</a></span>
                        <span><a class="p-1 dropdown-item" href="#">Another action</a></span>
                        <span><a class="p-1 dropdown-item" href="#">Something else here</a></span>
                    </div>
                </div>
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
                            Cart
                        </a>
                    </div>
                    <div class="mobile-nav nav-item dropdown">
                        <a class="nav-link justify-content-start" href="#">
                            Info
                        </a>
                        <div class="px-3" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item p-1" href="<?= Url::to(['/user/account/' . Yii::$app->user->id]) ?>">Account</a>
                            <a class="dropdown-item p-1" href="<?= Url::to(['/user/settings']) ?>">Settings</a>
                            <?= Html::a('Logout', ['/site/logout'], [
                                'class' => 'dropdown-item p-1',
                                'data' => [
                                    'method' => 'post',
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    </div>
</nav>
