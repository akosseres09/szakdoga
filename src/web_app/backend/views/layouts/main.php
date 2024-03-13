<?php
/* @var $this View*/
/* @var $content string*/

use yii\web\View;

$this->beginContent('@backend/views/layouts/base.php');?>
    <main role="main" class="flex-shrink-0 h-100"  >
        <header id="header">
            <?= $this->render('_header') ?>
        </header>
        <div class="container-fluid">
                <?= $content?>
        </div>
    </main>
<?php $this->endContent();