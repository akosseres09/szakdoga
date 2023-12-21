<?php
/**
 * @var View $this
 * @var Product $model
 */

use common\models\Product;
use yii\helpers\Url;
use yii\web\View;

$status = $model->getAvailability() === Product::ON_STOCK ? 'badge-available' : 'badge-unavailable';

?>

<div class="card-title pb-2 border-bottom d-flex justify-content-between gap-2 align-items-center">
    <div>
        <div class="product-name fw-bold fs-5">
            <?= $model->name ?>
        </div>
    </div>
</div>
<div class="card-body ">
    <img class="my-2" alt="Pics" src="<?=Url::to(['/storage/profile-pics/default_pic.jpg'])?>" style="border-radius: 15px; width: 75%; height: auto">
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
