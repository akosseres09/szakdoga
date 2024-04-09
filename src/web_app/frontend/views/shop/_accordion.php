<?php
/**
 * @var Product $product
 * @var ActiveDataProvider $reviews
 * @var View $this
 */

use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\View;

?>

<div class="row mt-4">
    <div class="col-lg-7">
        <div class="accordion" id="ratings">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" id="ratingObs" type="button" data-bs-toggle="collapse" data-bs-target="#ratingsAcc" aria-expanded="true" aria-controls="ratingsAcc">
                        <span>
                            Top Ratings
                        </span>
                        <span class="rating-container"></span>
                    </button>
                </h2>
                <div id="ratingsAcc" class="accordion-collapse collapse" data-bs-parent="#ratings">
                    <div class="accordion-body">
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion" id="description">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#descriptionAcc" aria-expanded="true" aria-controls="descriptionAcc">
                        Description
                    </button>
                </h2>
                <div id="descriptionAcc" class="accordion-collapse collapse" data-bs-parent="#description">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-9">
                                <h5>
                                    <?= $product->description_title ?>
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-*">
                                 <span class="mt-2">
                                    <?= $product->description ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion mb-lg-0 mb-4" id="details">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#detailsAcc" aria-expanded="true" aria-controls="detailsAcc">
                        Details
                    </button>
                </h2>
                <div id="detailsAcc" class="accordion-collapse collapse" data-bs-parent="#details">
                    <div class="accordion-body">
                        <?= $product->details ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 text-center">
        <button type="button" class="btn btn-primary" data-bs-target="#rating-modal" data-bs-toggle="modal">ADD RATING</button>
    </div>
</div>