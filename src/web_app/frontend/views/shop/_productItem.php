<?php
/**
 * @var View $this
 * @var Product $model
 */

use common\models\Product;
use yii\helpers\Url;
use yii\web\View;

$imageName = $model->getImages(true);

?>

<div class="card-body text-center ">
    <img class="my-2" alt="Pics" src="<?=Url::to(['/storage/images/'.$model->folder_id.'/'.$imageName[0]])?>" style="border-radius: 15px; width: 80%; height: auto">
</div>
<div class="card-footer">
    <div class="product-name">
        <?= $model->brand_name . ' ' . $model->name ?>
    </div>
    <div class="price row  d-flex justify-content-center align-items-center">
        <div class="col fs-4 fw-bold">
            $<?= $model->price ?>
        </div>
        <?php if (!$model->hasOnStock()) { ?>
            <span class="col me-2 badge text-bg-danger">Unavailable</span>
        <?php } ?>
    </div>
</div>
