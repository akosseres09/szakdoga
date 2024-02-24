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

echo $this->render('/site/common/_alert');

echo '<h1 class="text-center mb-4">Users</h1>';

echo GridView::widget([
    'dataProvider' => $users,
    'columns' => [
        'id',
        [
            'attribute' => 'username',
            'value' => function ($model) {
                $you = Yii::$app->user->id === $model->id ? ' (you)' : '';
                return $model->username . $you;
        },
        ],
        'email',
        [
            'attribute' => 'is_admin',
            'value' => function ($model) {
                return $model->getRole();
            }
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return $model->getStatus();
            }
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d H:i:s');
            }
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->updated_at, 'php:Y-m-d H:i:s');
            }
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'header' => 'Edit',
            'content' => function ($model) {
                $edit = Html::a('Edit', ['/user/edit/'.$model->id], ['class' => 'editUserBtn btn btn-primary me-2', 'data' => [
                    'bs-toggle' => 'modal',
                    'bs-target' => '#editUserModal'
                ]]);
                $delete = Html::a('Delete', ['/user/delete/'.$model->id], ['class' => 'btn btn-outline-light m-delete', 'data' => ['method' => 'POST']]);
                return
                    Yii::$app->user->id !== $model->id ? $edit . $delete : $edit;
            }
        ]
    ],
    'options' => ['class' => 'mx-5'],
    'tableOptions' => ['class' => 'table table-striped text-center align-middle'],
    'pager' => [
        'class' => LinkPager::class
    ],
    'layout' => '<div class="table-responsive">{items}</div>{pager}',

]);
?>

<div id="editUserModal" class="modal modal-md fade">
    <div class="modal-dialog">

    </div>
</div>
