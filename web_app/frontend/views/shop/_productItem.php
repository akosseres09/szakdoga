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

<div class="card-body text-center ">
    <img class="my-2" alt="Pics" src="<?=Url::to(['/storage/profile-pics/default_pic.jpg'])?>" style="border-radius: 15px; width: 150px; height: auto">
</div>
<div class="card-footer">
    <div class="product-name">
        <?= $model->name ?>
    </div>
    <div class="price">
        <div class="fs-4 fw-bold">
            $<?= $model->price ?>
        </div>
    </div>
</div>
