<?php
/**
 * @var string $title
 * @var string $text
 * @var bool $icon
 * @var string $link
 * @var string $linkText
 */

use yii\helpers\Url;

if (!isset($icon)) {
    $icon = true;
}

if (!isset($link)) {
    $link = Url::to(['/shop/products']);
}

if (!isset($linkText)) {
    $linkText = 'Browse Products';
}

?>

<div class="d-flex flex-column justify-content-center align-items-center gap-4 p-5">
    <?php if ($icon) { ?>
        <div class="cart-icon icon-xxl"></div>
    <?php } ?>
    <span class="fs-4 fw-semibold"><?= $title ?></span>
    <span class="fw-light fs-5 text-center" ><?= $text ?></span>
    <a href="<?= $link ?>" class="btn btn-outline-dark px-4 py-2">
        <span class="fs-5"><?= $linkText ?></span>
    </a>
</div>
