<?php


use common\models\Product;
use yii\helpers\Html;
use common\models\Order;
use yii\web\View;

/**
 * @var View $this
 * @var Order $model
 * @var int $index
 * @var int $total
 */
$imageName = $model->product->getImages(true);
?>

<a class="order-link d-flex flex-column" href="<?= Yii::$app->params['frontendUrl'] . '/shop/view/'.$model->product_id ?>">
    <div class="card-body">
        <img class="my-2" alt="Pics" src="<?=Yii::$app->params['frontendUrl'] . '/storage/images/'.$model->product->folder_id.'/'.$imageName[0]?>"
             style="border-radius: 15px; max-width: 100%; height: auto">
    </div>
    <div class="card-footer">
        <div class="product-name">
            <?=$model->product->brand_name . ' ' . $model->product->name ?>
        </div>
        <div class="product-details">
            <?= $model->product->type_name ?> <br>
            <?= Product::GENDERS[$model->product->gender] ?>,
            Size <?= Html::encode($model->size) ?>
        </div>
        <div class="price">
            <div class="fs-4 fw-bold">
                $<?= Html::encode($model->quantity * $model->product->price) ?>
            </div>
        </div>
    </div>
</a>