<?php
/**
 * @var View $this
 * @var User $user
 */

use common\models\User;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>


<div class="row">
    <?php $form = ActiveForm::begin() ?>
    <div class="col-lg-12 p-3 py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Profile Settings</h4>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label for="username" class="labels">Username</label>
                <input type="text" id="username" class="form-control" placeholder="Username"
                       value="<?= Yii::$app->user->identity->username ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <label for="email" class="labels">Email address</label>
                <input type="email" id="email" class="form-control" placeholder="Email address"
                       value="<?= Yii::$app->user->identity->email ?>">
            </div>
        </div>
        <div class="col-lg-4 mt-5 text-center">
            <?=
                Html::submitButton('Save Profile' ,[
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
