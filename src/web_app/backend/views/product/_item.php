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

$array = $model->getImages(true);
$link = Yii::$app->params['frontendImagesUrl'].$model->folder_id.'/';


$this->registerJs(<<<JS
    $(document).on('click', '.editProductItemBtn', function (e) {
        const modal = document.getElementById('productEditModal');
        getDataFromUrl(e.currentTarget.href, modal)
    });
JS);

?>

<div class="card-title pb-2 border-bottom gap-2 ">
    <div class="mx-4">
        <div class="row">
            <div class="col p-0 fw-bold product-name">
                <a class="product-name" href="http://sportify.test/shop/view/<?=$model->id?>">
                    <?=$model->brand->name . ' ' . $model->name ?>
                </a>
            </div>
        </div>
        <div class="row pt-1 d-flex">
            <div class="col-auto me-1 product-status badge badge-<?=$active?>">
                <?= ucfirst($active) ?>
            </div>
            <div class="col-auto badge badge-brown product-name flex-shrink-1">
                <?= $model->type->product_type ?>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-2 text-left">
                <a class="editProductItemBtn" data-bs-toggle="modal" data-bs-target="#productEditModal" href="<?= Url::to(['/product/edit/'.$model->id]) ?>" style="color: grey">
                    <span class="material-symbols-outlined">
                        edit
                    </span>
                </a>
            </div>
            <div class="col-2">
                <a href="<?= Url::to(['/product/delete/'.$model->id]) ?>" data-method="POST" style="color: red">
                <span class="material-symbols-outlined">
                    delete
                </span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="card-body text-center">
    <img class="my-2" alt="Pics" src="<?=$link.$array[0]?>" style="border-radius: 15px; width: 75%; height: auto">
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
