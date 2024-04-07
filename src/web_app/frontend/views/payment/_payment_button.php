<?php
/**
 * @var View $this
 * @var int $total
 */

use yii\web\View;

?>


<div class="payment-button">
    <div class="summary-row-total">
        <span class="text-total">Total</span>
        <span class="sub-total">$<?= $total ?></span>
    </div>
    <button type="submit" class="w-100 btn go-to-payment-info ">
        Pay
        <span class="ps-2 material-symbols-outlined">chevron_right</span>
    </button>
</div>
