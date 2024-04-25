<?php
/**
 * @var User $user
 */

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div id="profile-card" class="col-lg-3 " style="border-right: darkgray solid 1px">
    <div class="d-flex flex-column align-items-center text-center py-5">
        <img class="rounded-circle" width="150px"
             src="<?= $user->getProfilePic();?>" alt="Profile pic">
        <span class="font-weight-bold"><?= Html::encode(ucfirst($user->username))?></span>
        <span class="text-black-50"><?= Html::encode(Yii::$app->user->identity->email) ?></span>
        <span class="text-black-50">Registered at: <?= Yii::$app->formatter->asDate($user->created_at) ?></span>
        <span class="text-black-50">Last Login at: <?= Yii::$app->formatter->asDate($user->last_login_at) ?></span>
        <span class="text-black-50 mt-3">
            <a href="<?= Url::to(['/user/settings']) ?>" id="updateUserBtn" class="btn btn-primary">Update Profile</a>
        </span>
    </div>
</div>
