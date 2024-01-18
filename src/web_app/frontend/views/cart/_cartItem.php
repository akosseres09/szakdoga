<?php

use common\models\Cart;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var Cart $model
 */

?>

<div class=" mt-3 p-2" style="background-color: lightgrey; border-radius: 10px">
    <div class="row">
        <span class="d-flex justify-content-between fw-bold mb-2">
            <a href="<?= Url::to(['/shop/view/'.$model->product_id]) ?>">
                <?=$model->product->brand->name . ' ' . $model->product->name ?>
            </a>
            <a type="button" data-bs-toggle="modal" href="/cart/delete-from-cart/<?=$model->id?>" data-bs-target="#deleteModal" class="btn-close" aria-label="Close"></a>
        </span>
        <img src="/storage/profile-pics/default_pic.jpg" style="width: 15%;">
    </div>
</div>
