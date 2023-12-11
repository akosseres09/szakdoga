<?php

/** @var View $this */
/** @var ActiveForm $form */
/** @var LoginForm $model */

use common\models\LoginForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = 'Login';
?>
<div class="container-fluid">
   <div class="container">
       <div class="site-login">
           <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message):
               if(str_contains($key, 'Success')): ?>
                   <div class="alert alert-success  my-3">
                       <?= $message ?>
                   </div>
               <?php elseif (str_contains($key, 'Error')): ?>
                   <div class="alert alert-danger my-3">
                       <?= $message ?>
                   </div>
               <?php endif;
           endforeach; ?>
           <div class="mt-5 col-sm-12">
              <div class="row">
                  <h1><?= Html::encode($this->title) ?></h1>
              </div>
               <div class="row">
                   <p>Please fill out the following fields to login:</p>
               </div>
               <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
               <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
               <?= $form->field($model, 'password')->passwordInput() ?>
               <?= $form->field($model, 'rememberMe')->checkbox() ?>
               <div class="form-group">
                   <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
               </div>

               <?php ActiveForm::end(); ?>
           </div>
       </div>
   </div>
</div>
