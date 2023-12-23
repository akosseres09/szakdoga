<?php

use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var ActiveDataProvider $cartItems
 * @var int $q
 * @var int $total
 */
$this->title = 'Cart - Sportify';
?>

<?= $this->render('/site/common/_alert') ?>

<div class="container-fluid mt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?=
                    ListView::widget([
                        'dataProvider' => $cartItems,
                        'itemView' => '_cartItem'
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

<div id="deleteModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">

    </div>
</div>
