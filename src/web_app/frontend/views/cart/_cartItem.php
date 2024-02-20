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
            <?php $form = ActiveForm::begin([
                'action' => '/cart/delete-from-cart',
                'id' => 'deleteCartForm'
            ]) ?>
            <input type="hidden" name="id" value="<?=$model->id?>">
            <button type="submit" class="btn-close deleteFromCart"></button>
            <?php ActiveForm::end(); ?>
        </span>
        <img src="/storage/profile-pics/default_pic.jpg" style="width: 15%;">
    </div>
</div>
