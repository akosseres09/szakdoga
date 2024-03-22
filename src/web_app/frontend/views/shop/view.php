<?php
/**
 * @var View $this
 * @var Product $product
 * @var Cart $cart
 * @var Rating $rating
 * @var ActiveDataProvider $reviews
 */

use common\models\Cart;
use common\models\Product;
use common\models\Rating;
use frontend\assets\FontAwesomeAsset;
use frontend\assets\ShopAsset;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap5\ActiveForm;

$this->title = $product->name . ' - Sportify';


ShopAsset::register($this);
FontAwesomeAsset::register($this);
$this->registerJsVar('urlLink', Url::to(['/shop/get-rating/'.$product->id]));
?>

<?= $this->render('/site/common/_alert') ?>

<div class="container-fluid mt-5">
    <div class="container">
        <?= $this->render('_viewItem', [
            'cart' => $cart,
            'product' => $product,
        ]) ?>
        <?= $this->render('_accordion', [
            'product' => $product,
            'reviews' => $reviews
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
            <?php $form = ActiveForm::begin([
                'id' => 'rating-form',
                'action' => '/shop/add-rating/'.$product->id
            ]) ?>
            <div class="modal-body">
                    <div class="d-flex flex-column align-items-start">
                        <div class="star-rating">
                            <?= $form->field($rating, 'rating')->radioList([
                                    5 => '', 4 => '', 3 => '', 2 => '', 1 => ''
                                ], [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        $check = $checked ? 'checked="checked"' : '';
                                        $field = '<input id="star' . $value . '" type="radio" name="' . $name . '" value="' . $value . '"' . $check . '>';
                                        $field .= '<label for="star' . $value . '"><i class="fa-regular fa-star"></i></label>';
                                        return $field;
                                    }
                                ]
                            )->label(false) ?>
                        </div>
                    </div>
                <div class="row mt-2">
                    <?= $form->field($rating,'description')->textarea([
                        'maxLength' => 2048
                    ]) ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add-rating-btn">Save changes</button>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
