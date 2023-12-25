<?php
/**
 * @var View $this
 * @var User $user
 */

use common\models\User;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap5\ActiveForm;
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
            <div class="col-12 d-flex justify-content-center">
                <div class="row mt-4 text-center">
                    <div class="col-8">
                        <?=
                            Html::a('Save Profile' ,['user/save-user'],[
                                'class' => [
                                    'btn btn-primary'
                                ],
                                'data' => [
                                    'method' => 'post'
                                ]
                            ]);
                        ?>
                    </div>
                    <div class="col-4">
                        <?=
                            Html::a('Cancel', ['/user/account'], [
                                'class' => [
                                    'btn btn-outline-light'
                                ]
                            ]);
                        ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
