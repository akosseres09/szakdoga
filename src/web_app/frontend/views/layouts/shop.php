<?php
/**
 * @var View $this
 * @var string $content
 */

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->beginContent('@frontend/views/layouts/main.php');
?>

<div class="row pt-5">
    <div class="col-lg-3 filter-container">
    <?= $content ?>
    </div>
</div>

<?php
$this->endContent();