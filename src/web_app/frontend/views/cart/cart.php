<?php

use frontend\assets\CartAsset;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var ActiveDataProvider $cartItems
 * @var int $q
 * @var int $total
 */

$this->title = 'Cart - Sportify';

$this->registerJsFile('/js/sweetalert2.all.min.js');
$this->registerCssFile('/css/sweetalert2.min.css');

CartAsset::register($this);

?>

<?= $this->render('/site/common/_alert') ?>

<?= $this->render('_cart-steps', [
    'cartDone' => false,
    'paymentInfoDone' => false
]) ?>

<div class="container-fluid mt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?=
                    ListView::widget([
                        'dataProvider' => $cartItems,
                        'itemView' => '_cartItem',
                        'pager' => [
                            'class' => LinkPager::class
                        ],
                        'emptyText' => '<h3 class="text-center mt-1">Your Cart is Empty! <a href='. Url::to(['/shop/products']) .'>Let\'s Go Shopping</a></h3>',
                        'summary' => '{begin}-{end}/{totalCount}',
                    ]);
                ?>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <h2 class="text-center">
                        Total
                    </h2>
                </div>
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
</div>