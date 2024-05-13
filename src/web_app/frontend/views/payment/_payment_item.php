<?php
/**
 * @var View $this
 * @var Cart $model
 * @var int $index
 * @var int $total
 */
use common\models\Cart;
use yii\helpers\Html;
use yii\web\View;

?>

<div class="information fw-bold">
    <?= Html::encode($model->product->brand->name) . ' ' . Html::encode($model->product->name) ?>
</div>
<?php if ($model->quantity === 1) { ?>
    <span class="price">$<?= Html::encode($model->product->price) ?></span>
<?php } else { ?>
    <span class="price"><?= Html::encode($model->quantity) ?>x $<?= Html::encode($model->product->price) ?></span>
<?php } ?>
