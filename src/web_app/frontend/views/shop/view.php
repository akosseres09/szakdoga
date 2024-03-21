<?php
/**
 * @var View $this
 * @var Product $product
 * @var Cart $cart
 * @var Rating $ratings
 */

use common\models\Cart;
use common\models\Product;
use common\models\Rating;
use frontend\assets\FontAwesomeAsset;
use frontend\assets\ShopAsset;
use yii\web\View;
use yii\bootstrap5\ActiveForm;

$this->title = $product->name . ' - Sportify';


ShopAsset::register($this);
FontAwesomeAsset::register($this);
?>

<?= $this->render('/site/common/_alert') ?>

<div class="container-fluid mt-5">
    <div class="container">
        <?= $this->render('_viewItem', [
            'cart' => $cart,
            'product' => $product
        ]) ?>
        <?= $this->render('_accordion', [
            'product' => $product
        ]) ?>
    </div>
</div>

<div class="modal fade" id="rating-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rate this product: <br> <?=$product->brand->name . ' ' . $product->name ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'rating-form',
                    'action' => '/shop/add-rating/'.$product->id
                ]) ?>
                    <div class="d-flex flex-column align-items-start">
                        <label>Rating</label>
                        <div class="star-rating">
                            <input id="star5" type="radio" name="rating" value="5">
                            <label for="star5">
                                <i class="fa-regular fa-star"></i>
                            </label>
                            <input id="star4" type="radio" name="rating" value="4"><label for="star4">
                                <i class="fa-regular fa-star"></i>
                            </label>
                            <input id="star3" type="radio" name="rating" value="3"><label for="star3">
                                <i class="fa-regular fa-star"></i>
                            </label>
                            <input id="star2" type="radio" name="rating" value="2"><label for="star2">
                                <i class="fa-regular fa-star"></i>
                            </label>
                            <input id="star1" type="radio" name="rating" value="1"><label for="star1">
                                <i class="fa-regular fa-star"></i>
                            </label>
                        </div>
                    </div>
                <div class="row mt-2">
                    <?= $form->field($ratings,'description')->textarea([
                        'maxLength' => 2048
                    ]) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
