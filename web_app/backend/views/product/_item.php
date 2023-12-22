<?php
/**
 * @var View $this
 * @var Product $model
 */
use common\models\Product;
use yii\helpers\Url;
use yii\web\View;

$active = strtolower($model->getActiveStatus());
$status = $model->getAvailability() === Product::ON_STOCK ? 'badge-available' : 'badge-unavailable';

?>


<!--<div class="card-body text-center ">-->
<!--    <img class="my-2" alt="Pics" src="--><?php //=Url::to(['/default_pic.jpg'])?><!--" style="border-radius: 15px; width: 150px; height: auto">-->
<!--</div>-->
<!--<div class="card-footer">-->
<!--    <div class="product-name">-->
<!--        --><?php //= $model->name ?>
<!--    </div>-->
<!--    <div class="price">-->
<!--        <div class="fs-4 fw-bold">-->
<!--            $--><?php //= $model->price ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="card-title pb-2 border-bottom gap-2 ">
    <div>
        <div class="product-name fw-bold fs-5">
            <?=$model->brand->name . $model->name ?>
        </div>
        <div class="product-status badge badge-<?=$active?>">
            <?= ucfirst($active) ?>
        </div>
    </div>
<!--    <div>-->
<!--        <a class="editProductItemBtn" data-bs-toggle="modal" data-bs-target="#productEditModal" href="--><?php //= Url::to(['/product/edit/'.$model->id]) ?><!--" style="color: grey">-->
<!--            <span class="material-symbols-outlined">-->
<!--                edit-->
<!--            </span>-->
<!--        </a>-->
<!--        <a href="--><?php //= Url::to(['/product/delete/'.$model->id]) ?><!--" data-method="POST" style="color: red">-->
<!--            <span class="material-symbols-outlined">-->
<!--                delete-->
<!--            </span>-->
<!--        </a>-->
<!--    </div>-->
</div>
<div class="card-body text-center">
    <img class="my-2" alt="Pics" src="<?=Url::to(['/default_pic.jpg'])?>" style="border-radius: 15px; width: 75%; height: auto">
</div>
<div class="card-footer">
    <div class="d-flex justify-content-between align-items-center">
        <div class="price">
            <div class="text-muted">
                Price
            </div>
            <div class="fs-4 fw-bold">
                $<?= $model->price ?>
            </div>
        </div>
        <div class="availability">
            <div class="text-muted">
                Availability
            </div>
            <div class="badge <?= $status ?>">
                <?= $model->getAvailability() ?>
            </div>
        </div>
    </div>
</div>