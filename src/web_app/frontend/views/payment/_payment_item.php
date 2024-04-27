<?php
/**
 * @var Cart $model
 * @var int $index
 * @var int $total
 */
use common\models\Cart;
use yii\helpers\Html;


?>

<div class="information fw-bold">
    <?= $model->product->brand->name . ' ' . $model->product->name ?>
</div>
<?php if ($model->quantity === 1) { ?>
    <span class="price">$<?= Html::encode($model->product->price) ?></span>
<?php } else { ?>
    <span class="price"><?= Html::encode($model->quantity) ?>x $<?= Html::encode($model->product->price) ?></span>
<?php } ?>
