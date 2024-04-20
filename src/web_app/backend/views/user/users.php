<?php
/**
 * @var UserSearch $search
 * @var ActiveDataProvider $users
 * @var View $this
 */

use common\models\search\UserSearch;
use common\models\User;
use common\widgets\Pager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;

$this->title = 'Sportify - Admin - Users';

echo $this->render('/site/common/_alert');

?>

<div class="my-4">
    <h1 class="text-center">Users</h1>
</div>

<?= GridView::widget([
    'dataProvider' => $users,
    'filterModel' => $search,
    'columns' => [
        [
            'class' => SerialColumn::class,
        ],
        [
            'attribute' => 'username',
            'value' => function ($model) {
                $you = Yii::$app->user->id === $model->id ? ' (you)' : '';
                return $model->username . $you;
            },
            'headerOptions' => [
                    'style' => 'min-width: 150px'
            ]
        ],
        [
            'attribute' => 'email',
            'headerOptions' => [
                'style' => 'min-width: 150px'
            ]
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return $model->getStatus();
            },
            'filter' =>Html::dropDownList('status', (int)$search->status, [
                    UserSearch::ALL_STATUS => 'All',
                    User::STATUS_ACTIVE => 'Active',
                    User::STATUS_INACTIVE=> 'Inactive'
                ],  [
                    'class' => 'form-control'
            ])
        ],
        [
            'attribute' => 'is_admin',
            'value' => function ($model) {
                return $model->getRole();
            },
            'filter' => Html::dropDownList('is_admin', $search->is_admin ?? UserSearch::ALL_TYPE, [
                UserSearch::ALL_TYPE => 'All',
                User::ADMIN => 'Admin',
                User::USER => 'User'
            ],
            [
                'class' => 'form-control'
            ])
        ],
        [
            'attribute' => 'created_at',
            'format' => 'raw',
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d H:i:s');
            },
            'filter' => DatePicker::widget([
                'model' => $search,
                'attribute' => 'created_at',
                'dateFormat' => 'php:Y-m-d',
                'options' => [
                        'class' => 'form-control'
                ],
            ]),
            'headerOptions' => [
                'style' => 'min-width: 200px'
            ]
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->updated_at, 'php:Y-m-d H:i:s');
            },
            'headerOptions' => [
                'style' => 'min-width: 200px'
            ]
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'header' => 'Edit',
            'content' => function ($model) {
                if ($model->deleted_at === null) {
                    $edit = Html::a('Edit', ['/user/edit/'.$model->id], ['class' => 'editUserBtn btn btn-primary me-2', 'data' => [
                        'bs-toggle' => 'modal',
                        'bs-target' => '#editUserModal'
                    ]]);
                    $delete = Html::a('Delete', ['/user/delete/'.$model->id], ['class' => 'btn btn-outline-dark m-delete', 'data' => ['method' => 'POST']]);
                    return Yii::$app->user->id !== $model->id ? $edit . $delete : $edit;
                } else {
                    return Html::a('Undo Delete', ['/user/undelete/'.$model->id], ['class' => 'btn btn-outline-warning m-delete', 'data' => [
                            'method' => 'POST'
                    ]]);
                }

            }
        ]
    ],
    'options' => ['class' => 'mx-5'],
    'tableOptions' => ['class' => 'table table-striped text-center align-middle'],
    'pager' => [
        'class' => Pager::class
    ],
    'layout' => '<div class="table-responsive">{items}</div>{pager}',

]);
?>

<div id="editUserModal" class="modal modal-md fade">
    <div class="modal-dialog">

    </div>
</div>
