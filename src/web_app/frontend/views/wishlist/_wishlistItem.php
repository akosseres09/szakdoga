<?php
/**
 * @var View $this
 * @var Wishlist $model
 */

use common\models\Wishlist;
use yii\helpers\Url;
use yii\web\View;

$image = $model->product->getImages(true);
$link = '/storage/images/' . $model->product->folder_id . '/';
?>


<div class="card-title pb-2 border-bottom gap-2 ">
    <div class="row">
        <div class="col p-0 fw-bold product-name">
            <a class="product-name" href="<?= Url::to(['/shop/view/'.$model->product->id]) ?>">
                <?=$model->product->brand->name . ' ' . $model->product->name ?>
            </a>
        </div>
        <div class="col-2">
            <a href="<?= Url::to(['/wishlist/delete-from-wishlist/'.$model->id]) ?>" data-method="POST" style="color: red">
            <span class="material-symbols-outlined">
                delete
            </span>
            </a>
        </div>
    </div>
</div>
<div class="card-body text-center">
    <img class="my-2" alt="Pics" src="<?=$link.$image[0]?>" style="border-radius: 15px; max-width: 75%; height: auto">
</div>
