<?php
/**
 * @var $this View
 * @var $content string
 */

use yii\web\View;
$this->beginContent('@frontend/views/layouts/base.php');
?>
<main role="main" class="flex-shrink-0 d-flex flex-column min-vh-100">
    <?= $content ?>
</main>
<?php $this->endContent();
