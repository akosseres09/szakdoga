<?php
/**
 * @var View $this
 * @var ActiveDataProvider $reviews
 */

use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

echo ListView::widget([
    'dataProvider' => $reviews,
    'itemView' => '_reviewItem',
    'layout' => '<div>
                    {items}
                </div>',
    'emptyText' => '<h6>No Reviews found!</h6>',
    'viewParams' => [
        'total' => $reviews->totalCount
    ]
]);


