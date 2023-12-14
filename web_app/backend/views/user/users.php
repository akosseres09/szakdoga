<?php
/**
 * @var ActiveDataProvider $users
 * @var View $this
 */

use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Sportify - Admin - Users';


echo GridView::widget([
    'dataProvider' => $users,
    'columns' => [
        'ID',
        'username',
        'email',
        'is_admin',
        'status',
        'created_at:datetime',
        'updated_at:datetime',
        [
            'class' => 'yii\grid\DataColumn',
            'header' => 'Edit',
            'content' => function ($model) {
                return
                    Yii::$app->user->id !== $model->id ?
                    Html::a('Edit', [''], ['class' => 'btn btn-primary me-2']) .
                    Html::a('Delete', [''], ['class' => 'btn btn-outline-light mt-2 mt-lg-0'])
                        : Html::a('Edit', [''], ['class' => 'btn btn-primary me-2']);
            }
        ]
    ],
    'options' => ['class' => 'mx-5 table-responsive'],
    'tableOptions' => ['class' => 'table table-striped text-center align-middle'],
    'pager' => [
        'class' => LinkPager::class
    ],
    'layout' => '<div class="table-responsive">{items}</div>{pager}',

]);
