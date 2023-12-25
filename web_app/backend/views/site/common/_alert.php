<?php

foreach (Yii::$app->session->getAllFlashes() as $key => $message):
    if(str_contains($key, 'Success')): ?>
        <div class="alert alert-success  mb-5">
            <?= $message ?>
        </div>
    <?php elseif (str_contains($key, 'Error')): ?>
        <div class="alert alert-danger mb-5">
            <?= $message ?>
        </div>
    <?php endif;
endforeach; ?>
