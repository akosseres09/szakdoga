<?php
/**
 * @var View $this
 * @var Product $product
 * @var bool $success
 * @var $errors
 */

use common\models\Product;
use yii\helpers\Url;
use yii\web\View;

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?= $success ? 'Product Added to Cart' : 'Failed To Add to Cart' ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php if ($success) { ?>
                <div class="row">
                    <div class="col">
                        <span><?= $product->brand->name . ' ' . $product->name ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <span>$<?= $product->price ?></span>
                    </div>
                </div>
            <?php } else {
                foreach ($errors as $error) { ?>
                    <span> <?= $error[0] ?> </span>
                <?php }
            } ?>
        </div>
        <div class="modal-footer">
            <?php if ($success) { ?>
                <a href="<?= Url::to(['/cart/cart']) ?>" class="btn btn-primary">Go to Cart</a>
                <a href="<?= Url::to(['/shop/products']) ?>" class="btn btn-outline-light">Back to Shop</a>
            <?php  } else { ?>
                <button class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
            <?php } ?>
        </div>
    </div>

</div>