<?php
/**
 * @var View $this
 * @var User $user
 */

use common\models\User;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
$this->title = 'Update Your Profile';

?>


<div class="row">
    <?php $form = ActiveForm::begin() ?>
    <div class="col-lg-12 p-3 py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Profile Settings</h4>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <?= $form->field($user, 'username')
                    ->textInput(['placeholder' => 'Username', 'value' => $user->username]) ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <?= $form->field($user, 'email')
                    ->Textinput(['type' => 'email' ,'placeholder' => 'Email address', 'value' => $user->email]) ?>
            </div>
        </div>
        <div class="col-lg-4 mt-5 text-center">
            <?=
                Html::a('Save Profile' ,['user/save-user/'.$user->id],[
                    'class' => [
                            'flex-1 btn btn-success'
                        ],
                        'data' => [
                                'method' => 'post'
                        ]
                ]);
            ?>
            <?=
            Html::a('Cancel', ['/user/account'], [
                'class' => [
                        'flex-1 btn btn-danger'
                ]
            ]);
            ?>
        </div>
        <?php ActiveForm::end();?>
    </div>
</div>
