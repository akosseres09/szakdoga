<?php
/**
 * @var View $this
 * @var Product $product
 * @var bool $success
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
            <?php } else { ?>
                <span>Something Went Wrong When Adding Product to Cart</span>
            <?php } ?>
        </div>
        <div class="modal-footer">
            <a href="<?= Url::to(['/cart/cart']) ?>" class="btn btn-primary">Go to Cart</a>
            <a href="<?= Url::to(['/shop/products']) ?>" class="btn btn-outline-light">Back to Shop</a>
        </div>
    </div>

</div>