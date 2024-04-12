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

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit User: <?= $user->username ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php $form = ActiveForm::begin([
            'action' => '/user/update'
        ]) ?>
        <div class="modal-body">
            <div class="row">
                <?= $form->field($user, 'username')->textInput(['placeholder' => 'username', 'required' => true, 'maxlength' => 255])?>
            </div>
            <div class="row mt-3">
                <?= $form->field($user, 'email')->textInput(['placeholder' => 'email', 'required' => true, 'maxlength' => 255]) ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
