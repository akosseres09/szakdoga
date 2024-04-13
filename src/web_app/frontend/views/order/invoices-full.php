<?php
/**
 * @var View $this
 * @var ArrayDataProvider $invoices
 */

use yii\data\ArrayDataProvider;
use yii\web\View;
$this->render('/site/common/_alert');
$this->beginContent('@frontend/views/user/account-wrapper.php');
?>
<div class="container rounded bg-white mt-5 mb-5">
    <div id="settings-container" class="row justify-content-evenly">
        <?=
            $this->render('invoices', [
                'invoices' => $invoices
            ]);
        ?>
    </div>
</div>
<?php $this->endContent();