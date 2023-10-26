<?php
/**
 * @var View $this
 * @var BillingInformation $billingInfo
 */

use common\models\BillingInformation;
use yii\helpers\Url;
use yii\web\View;



?>
<div class="col-lg-4">
    <div class="p-1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Billing Information</h4>
            <span class="material-symbols-outlined write" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Billing Info" style="cursor:pointer;">
                <a href="<?= Url::to(['/user/add-billing']) ?>">edit</a>
            </span>
        </div>
        <?php if ($billingInfo->hasNull()) : ?>
            <h5>No results Found</h5>
        <?php else: ?>
            <div class="row mt-3">
                <?php foreach ($billingInfo as $key => $value) :
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