<?php


use common\models\Product;
use yii\helpers\Html;
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
    
    .card-body {
        min-width: fit-content;
        max-width: fit-content;
    }
    
    .card-footer > * {
        overflow: hidden;   
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .card-footer > .product-name {
        width: 80%;
        font-weight: bold;
    }
        
    .order-link {
        transition: transform 0.2s ease-in-out;
    }
    
    .order-link:hover {
        transform: scale(1.01);
    }

CSS);

?>

<a class="order-link d-flex flex-column" href="<?= Url::to(['/shop/view/'.$model->product_id]) ?>">
    <div class="card-body">
        <img class="my-2" alt="Pics" src="<?=Url::to(['/storage/images/'.$model->product->folder_id.'/'.$imageName[0]])?>"
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