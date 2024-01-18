<?php

foreach (Yii::$app->session->getAllFlashes() as $key => $message):
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
