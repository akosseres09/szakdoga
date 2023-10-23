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


<div class="user-update">
    <div class="row">
        <?php $form = ActiveForm::begin() ?>
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="col-md-10 mt-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="text-right">Update Profile</h4>
                </div>
            </div>
            <div class="col-10">
                <div class="col-md-12">
                    <div class="mb-4">
                        <?= $form->field($user, 'username')
                            ->textInput(['placeholder' => 'Username', 'value' => $user->username]) ?>
                    </div>
                    <div>
                        <?= $form->field($user, 'email')
                            ->Textinput(['type' => 'email' ,'placeholder' => 'Email address', 'value' => $user->email]) ?>
                    </div>
                </div>
            <div class="d-flex justify-content-center">
                <div class="col-lg-4 mt-4 text-center">
                    <?=
                    Html::a('Save Profile' ,['user/save-user/'.$user->id],[
                        'class' => [
                            'btn btn-success'
                        ],
                        'data' => [
                            'method' => 'post'
                        ]
                    ]);
                    ?>
                    <?=
                    Html::a('Cancel', ['/user/account'], [
                        'class' => [
                            'btn btn-danger'
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
