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
        <?=$model->brand->name . ' ' . $model->name ?>
    </div>
    <div class="price">
        <div class="fs-4 fw-bold">
            $<?= $model->price ?>
        </div>
    </div>
</div>
