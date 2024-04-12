<?php
/**
 * @var View $this
 * @var ActiveDataProvider $wishlistItems
 */

use common\widgets\Pager;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

echo
    ListView::widget([
        'dataProvider' => $wishlistItems,
        'pager' => [
            'class' => Pager::class
        ],
        'emptyText' => $this->render('/common/_empty_text', [
            'title' => 'No Wishlisted Items',
            'text' => 'You didn\'t add any item to your wishlist yet. Browse the website to find amazing deals!'
        ]),
        'itemView' => '_wishlistItem',
        'layout' => '<div class="container-fluid position-relative">
            <div class="container mb-5">
                <div class="wishlist-items-grid-container">{items}</div>
            </div>
            <div class="d-flex justify-content-center">
                {pager}
            </div>
        </div>'
    ])
?>
