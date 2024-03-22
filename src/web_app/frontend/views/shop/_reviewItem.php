<?php
/**
 * @var Rating $model
 * @var View $this
 * @var int $index
 * @var int $total
 */

use common\models\Rating;
use yii\web\View;

$this->registerCss(<<<CSS
    .star-rating .star {
        color: lightgray;
    }

    .star-rating .star.checked {
        color: gold;
    }
CSS);
?>
<div class="container <?= $index !== $total-1 ? 'border-bottom pb-2' : ''?>">
    <div class="star-rating">
        <?php for ($i = 0; $i < 5; $i++) { ?>
            <i class="star fa-regular fa-star <?= $i <= $model->rating ? 'checked' : '' ?>"></i>
        <?php } ?>
    </div>
    <span class="fw-light ms-2">
        <?= Yii::$app->formatter->asDate($model->createdAt) . ' - ' . $model->user->username . ' (' .  $model->user->email . ')' ?>
    </span>
    <div class="mt-1">
        <?= $model->description ?>
    </div>
</div>


