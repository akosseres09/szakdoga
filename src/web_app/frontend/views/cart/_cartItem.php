<?php

use common\models\Cart;
use yii\helpers\Url;

/**
 * @var Cart $model
 * @var int $index
 * @var int $total
 */

$image = $model->product->getImages(true);
?>

<div class="mt-4 mx-4" <?= $index !== $total - 1 ? 'style="border-bottom: 1px solid var(--spfy-primary-light)"' : '' ?>>
    <div class="row pb-4">
        <div class="d-none d-md-flex col-2">
            <img src="/storage/images/<?= $model->product->folder_id ?>/<?= $image[0] ?>" alt="Item picture" style="width:100%; border-radius: 10px">
        </div>
        <div class="col-md-10 col-12">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <a href="<?= Url::to(['/shop/view/'.$model->product_id]) ?>" class="fw-bold">
                            <?=$model->product->brand->name . ' ' . $model->product->name ?>
                        </a>
                    </div>
                    <div class="row pt-2 pb-3">
                        <span class="col fw-semibold">
                            <?= $model->size ?>
                            <?= $model->product->type->product_type ?>
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="delete-from-cart material-symbols-outlined pe-2" data-href="<?= Url::to(['/cart/delete-from-cart/' . $model->id]) ?>" style="border-right: 1px solid grey">delete</span>
                        <span class="move-to-wishlist fw-light" data-href="<?= Url::to(['/cart/move-to-wishlist/' . $model->id]) ?>">Move to wishlist</span>
                    </div>
                </div>
                <div class="col-2 d-flex justify-content-end align-items-center">
                    <span class="fw-bold fs-5">
                         $<?= $model->price ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
