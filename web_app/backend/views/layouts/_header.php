<?php
/**
 * @var View $this
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$actionName = Yii::$app->controller->action->id;

?>
<nav id="mobile-header" class="d-none navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand">Sportify</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-nav me-auto px-3">
                <div>
                    <div class="mobile-nav nav-item dropdown">
                        <a class="nav-link justify-content-start" href="<?= Url::to(['/user/users']) ?>">
                            Users
                        </a>
                    </div>
                </div>
                <div>
                    <div class="mobile-nav nav-item dropdown">
                        <a class="nav-link justify-content-start" href="<?= Url::to(['/order/orders']) ?>">
                            Orders
                        </a>
                    </div>
                </div>
                <div>
                    <div class="mobile-nav nav-item dropdown">
                        <a class="nav-link justify-content-start" href="<?= Url::to(['/product/products']) ?>">
                            Products
                        </a>
                    </div>
                </div>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <div class="mobile-nav nav-item dropdown">
                        <a class="nav-link justify-content-start" href="#">
                            Profile
                        </a>
                        <div class="px-3 drop" aria-labelledby="navbarDropdown">
                        <span>
                            <a class="dropdown-item p-1" href="<?= Url::to(['/user/settings']) ?>">Settings</a>
                        </span>
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
                <?php endif; ?>
            </div>
    </div>
</nav>


<nav id="desktop-header" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <span class="navbar-brand">
            Sportify
        </span>
        <div class="navbar-collapse d-flex justify-content-evenly" id="navbarSupportedContent">
            <div class="navbar-nav me-auto mb-2 mb-lg-0 d-flex gap-2 flex-1">
                <div class="d-flex gap-3 align-items-center flex-1">
                    <div class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['user/users']) ?>">
                            Users
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['order/orders']) ?>">
                            Orders
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['product/products']) ?>">
                            Products
                        </a>
                    </div>
                </div>

                <?php if(!Yii::$app->user->isGuest): ?>
                <div class="nav-item dropdown" id="profile" style="padding-right: 30px">
                    <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-outlined">account_circle</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="transform: translateX(-50%)">
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
            <?php endif; ?>
            </div>
        </div>
    </div>
</nav>