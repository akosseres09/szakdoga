<?php
/**
 * @var ActiveDataProvider $users
 * @var View $this
 */

use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;


echo ListView::widget([
   'dataProvider' => $users,
    'pager' => [
        'class' => LinkPager::class
    ],
    'itemView' => '_userItem',
    'layout' => '<div>{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false
    ]
]);
