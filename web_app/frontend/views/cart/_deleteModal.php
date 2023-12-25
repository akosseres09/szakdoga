<?php
/**
 * @var View $this
 * @var Cart $item
 */

use common\models\Cart;
use yii\web\View;
use yii\widgets\ActiveForm;

?>


<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Delete this item from your cart?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer">
            <?php ActiveForm::begin([
                'action' => '/cart/delete-from-cart/'.$item->id,
                'method' => 'POST'
            ]) ?>
            <button type="submit" class="btn btn-primary">Delete</button>
            <?php ActiveForm::end() ?>
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-light">Cancel</button>
        </div>
    </div>
</div>
