<?php

use yii\data\ArrayDataProvider;
use yii\helpers\Url;

/**
 * @var $products ArrayDataProvider
 */

?>

<div class="container-fluid position-relative">

</div>
<a class="position-absolute add-new-btn" href="<?= Url::to(['/product/add']) ?>">
    <span class="material-symbols-outlined">
        add
    </span>
</a>
