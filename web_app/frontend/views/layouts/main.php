<?php
/* @var $this View*/
/* @var $content string*/

use yii\web\View;

$this->beginContent('@frontend/views/layouts/base.php');?>
<main role="main" class="flex-shrink-0 h-100"  >
    <header>
        <?= $this->render('_header')?>
    </header>
    <div class="container" id="outer-container" style="padding-top: 0">
        <?= $content?>
    </div>
    <footer>
        <?= $this->render('_footer') ?>
    </footer>
</main>
<?php $this->endContent();?>
