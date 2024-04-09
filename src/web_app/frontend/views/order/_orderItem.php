<?php


use common\models\Product;
use yii\helpers\Url;
use common\models\Order;
use yii\web\View;

/**
 * @var View $this
 * @var Order $model
 * @var int $index
 * @var int $total
 */
$imageName = $model->product->getImages(true);

$this->registerCss(<<<CSS
    .card-footer > *:not(.product-name){
        color: initial;
    }
    
    .card-footer > *.product-name {
        font-weight: bold;
    }
    
    .order-link:hover {
        transform: scale(1.5);
    }

CSS);

?>

<a class="order-link" href="<?= Url::to(['/shop/view/'.$model->product_id]) ?>">
    <div class="card-body">
        <img class="my-2" alt="Pics" src="<?=Url::to(['/storage/images/'.$model->product->folder_id.'/'.$imageName[0]])?>" style="border-radius: 15px; width: 80%; height: auto">
    </div>
    <div class="card-footer">
        <div class="product-name">
            <?=$model->product->brand->name . ' ' . $model->product->name ?>
        </div>
        <div class="product-details">
            <?= $model->product->type->product_type ?> <br>
            <?= Product::GENDERS[$model->product->gender] ?>,
            Size <?= $model->size ?>
        </div>
        <div class="price">
            <div class="fs-4 fw-bold">
                $<?= $model->quantity * $model->product->price ?>
            </div>
        </div>
    </div>
</a>