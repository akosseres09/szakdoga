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

<div class="container-fluid">
    <div class="container" >
        <?php $form = ActiveForm::begin([
            'action' => '/user/edit/'.$user->id
        ]) ?>

        <div class="row mb-4">
            <div class="col-sm">
                <?= $form->field($user, 'username') ?>
            </div>
            <div class="col-sm">
                <?= $form->field($user, 'email') ?>
            </div>
            <?php if ($user->id !== Yii::$app->user->id) { ?>
            <div class="col-lg mt-4 mt-lg-0 d-flex justify-content-center align-items-center">
                <?= $user->is_admin  ?  Html::a('Demote From Admin', ['/user/change-role/'.$user->id], ['class' => 'btn btn-outline-light'])
                    : Html::a('Upgrade to Admin', ['/user/change-role/'.$user->id], ['class' => 'btn btn-outline-light', 'data' => ['method' => 'post']]) ?>
            </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <?= Html::submitButton('Edit User', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>
