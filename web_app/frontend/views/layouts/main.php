<?php
/* @var $this View*/
/* @var $content string*/

use yii\web\View;

$this->beginContent('@frontend/views/layouts/base.php');?>
<header id="header">
    <?=  $this->render('_header') ?>
</header>
<main role="main" class="flex-shrink-0">
    <div class="container" id="outer-container" style="padding-top: 0">
        <?= $content?>
    </div>
</main>
<footer class="footer mt-auto py-3 text-muted">
    <?= $this->render('_footer') ?>
</footer>
<?php $this->endContent();?>
