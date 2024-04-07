<?php
/**
 * @var Cart $model
 * @var int $index
 * @var int $total
 */
use common\models\Cart;


?>

<div class="information fw-bold">
    <?= $model->product->brand->name . ' ' . $model->product->name ?>
</div>
<?php if ($model->quantity === 1) { ?>
    <span class="price">$<?= $model->product->price ?></span>
<?php } else { ?>
    <span class="price"><?= $model->quantity ?>x $<?= $model->product->price ?></span>
<?php } ?>
