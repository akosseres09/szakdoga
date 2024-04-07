<?php
/**
 * @var View $this
 * @var ActiveDataProvider $products
 */

use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

?>


<h4>Summary</h4>
<div class="pay-summary mb-4">
    <div class="summary <?= $products->totalCount > 2 ? 'long' : '' ?>">
        <div class="items">
            <?=
            ListView::widget([
                'dataProvider' => $products,
                'itemView' => '/payment/_payment_item',
                'summary' => false,
                'layout' => '{items}',
                'itemOptions' => [
                    'class' => 'item'
                ],
                'viewParams' => [
                    'total' => $products->totalCount
                ]
            ])
            ?>
        </div>
        <div class="summary-click-spread">
            Click To Spread
        </div>
    </div>
</div>
