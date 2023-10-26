<?php

use common\models\ShippingInformation;
use yii\helpers\Url;
use yii\web\View;
/**
 * @var View $this
 * @var ShippingInformation $shippingInfo
 */
?>
<div class="col-lg-4">
    <div class="p-1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Shipping Information</h4>
            <span class="material-symbols-outlined write" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Shipping Info" style="cursor:pointer;">
                <a href="<?= Url::to(['/user/add-shipping']) ?>">edit</a>
            </span>
        </div>
        <?php if ($shippingInfo->hasNull()) : ?>
            <h5>No results Found</h5>
        <?php else: ?>
            <div class="row mt-3">
                <?php foreach ($shippingInfo as $key => $value) :
                    if ($key === 'id' || $key == 'user_id') continue; ?>
                    <div class="col-md-12 pb-3 d-flex flex-column">
                        <span class="label-bs fw-bold"> <?= ucfirst($key) ?></span>
                        <span class="input-bs"> <?= $value ?> </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>