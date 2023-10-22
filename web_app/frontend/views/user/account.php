<?php
/**
 * @var View $this
 * @var User $user
 */

use common\models\User;
use yii\helpers\Url;
use yii\web\View;

Yii::$app->formatter->locale = 'en_US';
?>

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 " style="border-right: darkgray solid 1px">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle" width="150px"
                     src="<?= $user->getProfilePic();?>" alt="Profile pic">
                <span class="font-weight-bold"><?=ucfirst(Yii::$app->user->identity->username)?></span>
                <span class="text-black-50"><?= Yii::$app->user->identity->email ?></span>
                <span class="text-black-50">Registered at: <?= Yii::$app->formatter->asDate(Yii::$app->user->identity->created_at) ?></span>
                <span class="text-black-50">Last Login at: <?= Yii::$app->formatter->asDate(Yii::$app->user->identity->last_login_at) ?></span>
                <span class="text-black-50 mt-3">
                    <a href="<?= Url::to(['user/update/' . Yii::$app->user->id]) ?>" class="btn btn-success">Update Profile</a>
                </span>
            </div>
        </div>

        <div class="col-md-4 border-right">
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Billing Information</h4>
                </div>
                <div class="row mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="country" class="labels">Country</label>
                            <input id="country" type="text" class="form-control" placeholder="Hungary" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="labels">State/Region</label>
                            <input id="state" type="text" class="form-control" value="" placeholder="Csongrád">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="labels" for="city">City</label>
                        <input id="city" type="text" class="form-control" placeholder="Szeged" value="" required>
                    </div>
                    <div class="col-md-12">
                        <label class="labels" for="street">Street</label>
                        <input id="street" type="text" class="form-control" placeholder="Tisza Lajos krt. 103" value="">
                    </div>
                    <div class="col-md-12">
                        <label for="postcode" class="labels">Postcode</label>
                        <input id="postcode" type="text" class="form-control" placeholder="6725" value="">
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <a href="<?= Url::to(['/user/save-billing/' . Yii::$app->user->id]) ?>" class="btn btn-primary profile-button" type="button">Save Billing information</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Shipping Information</h4>
                </div>
                <div class="row mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="country" class="labels">Country</label>
                            <input id="country" type="text" class="form-control" placeholder="Hungary" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="labels">State/Region</label>
                            <input id="state" type="text" class="form-control" value="" placeholder="Csongrád">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="labels" for="city">City</label>
                        <input id="city" type="text" class="form-control" placeholder="Szeged" value="" required>
                    </div>
                    <div class="col-md-12">
                        <label class="labels" for="street">Street</label>
                        <input id="street" type="text" class="form-control" placeholder="Tisza Lajos krt. 103" value="">
                    </div>
                    <div class="col-md-12">
                        <label for="postcode" class="labels">Postcode</label>
                        <input id="postcode" type="text" class="form-control" placeholder="6725" value="">
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <a href="<?= Url::to(['/user/save-shipping/' . Yii::$app->user->id]) ?>" class="btn btn-primary profile-button" type="button">Save Billing information</a>
                </div>
            </div>
        </div>
    </div>
</div>