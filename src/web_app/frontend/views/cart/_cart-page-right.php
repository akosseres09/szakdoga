<?php
/**
 * @var int $total
 * @var int $totalCount
 */

use yii\helpers\Url;

?>

<div class="row">
    <span class="fw-semibold fs-4">Summary</span>
    <div class="py-2 mt-2 cart-page-grey-container-summary" >
        <div class="summary-container p-3">
            <div class="summary-row">
                <span class="fw-light">Official Price:</span>
                <span id="official-price" class="fw-light">$<?= $total ?></span>
            </div>
            <div class="summary-row">
                <span class="fw-light">Discount:</span>
                <span id="discount" class="fw-light">$0</span>
            </div>
            <div class="summary-row">
                <span class="fw-bold">Subtotal:</span>
                <span id="subtotal" class="fw-bold fs-5">$<?= $total ?></span>
            </div>
            <a href="<?= $totalCount === 0 ? '#' : Url::to(['/cart/payment-info']) ?>"
               class="btn go-to-payment-info <?= $total === 0 ? 'btn-disabled' : '' ?>">Payment Information
                <span class="ps-2 material-symbols-outlined">chevron_right</span>
            </a>
            <span class="choice">or</span>
            <a href="<?= Url::to(['/shop/products']) ?>" class="continue-shopping fw-light">
                <span class="pe-2 material-symbols-outlined">chevron_left</span>
                Continue Shopping
            </a>
        </div>
    </div>
</div>