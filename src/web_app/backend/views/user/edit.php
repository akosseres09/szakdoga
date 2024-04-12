<?php

use common\components\Html;
use common\models\User;
use yii\web\View;
use yii\bootstrap5\ActiveForm;

/**
 * @var View $this
 * @var User $user
 */

$this->title = 'Edit User - Sportify'
?>

<div class="modal-dialog">
    <?php $form = ActiveForm::begin([
        'action' => '/user/edit/'.$user->id
    ]) ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit User: <?= $user->username ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <?= $form->field($user,'username')->textInput(['maxlength' => 255, 'required' => true])?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?= $form->field($user, 'email')->textInput(['type' => 'email', 'maxlength' => 255, 'required' => true]) ?>
                </div>
            </div>
            <div class="row">
                <?php if ($user->id !== Yii::$app->user->id) { ?>
                    <div class="col-lg mt-2 mb-2 d-flex justify-content-center align-items-center">
                        <?= $user->is_admin  ?  Html::a('Demote From Admin', ['/user/change-role/'.$user->id], ['class' => 'btn btn-outline-dark'])
                            : Html::a('Upgrade to Admin', ['/user/change-role/'.$user->id], ['class' => 'btn btn-outline-dark', 'data' => ['method' => 'post']]) ?>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <?= Html::submitButton('Edit User', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>