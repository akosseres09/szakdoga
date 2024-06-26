<?php
/**
 * @var Rating $model
 * @var View $this
 * @var int $index
 * @var int $total
 */

use common\models\Rating;
use yii\helpers\Html;
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
        <?php for ($i = 5; $i > 0; $i--) { ?>
            <i class="star fa-regular fa-star <?= $i <= $model->rating ? 'checked' : '' ?>"></i>
        <?php } ?>
    </div>
    <span class="fw-light ms-2">
        <?= Yii::$app->formatter->asDate($model->created_at) . ' - ' . Html::encode($model->user->username) . ' (' .  Html::encode($model->user->email) . ')' ?>
    </span>
    <div class="mt-1">
        <?= Html::encode($model->description) ?>
    </div>
</div>


