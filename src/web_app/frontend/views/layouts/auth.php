<?php
/* @var $this View*/
/* @var $content string*/

use yii\web\View;

$this->beginContent('@frontend/views/layouts/base.php');?>
    <main role="main" class="flex-shrink-0 h-100"  >
        <div class="container" id="outer-container">
            <?= $content?>
        </div>
    </main>
<?php $this->endContent();?>
<?php
