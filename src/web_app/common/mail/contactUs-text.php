<?php
/**
 * @var View $this
 * @var ContactForm $form
 */

use frontend\models\ContactForm;
use yii\web\View;

?>

Contact was made by: <?= $form->email ?>!

Subject: <?= $form->subject ?>

Body:
<?= $form->body ?>