<?php
/**
 * @var string $title
 * @var string $text
 */

?>

<div class="d-flex flex-column justify-content-center align-items-center gap-4 p-5">
    <div class="cart-icon icon-xxl"></div>
    <span class="fs-4 fw-semibold"><?= $title ?></span>
    <span class="fw-light fs-5 text-center" ><?= $text ?></span>
    <a href="/shop/products" class="btn btn-outline-dark px-4 py-2">
        <span class="fs-5">Browse Products</span>
    </a>
</div>
