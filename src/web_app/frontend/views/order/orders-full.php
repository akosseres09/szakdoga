<?php
/**
 * @var View $this
 * @var ActiveDataProvider $orders
 */

use yii\data\ActiveDataProvider;
use yii\web\View;
$this->render('/site/common/_alert');
$this->beginContent('@frontend/views/user/account-wrapper.php');
?>

    <div class="container rounded bg-white mt-5 mb-5">
        <div id="settings-container" class="row justify-content-evenly">
            <?=
            $this->render('orders', [
                'orders' => $orders
            ]);
            ?>
        </div>
    </div>

<?php $this->endContent();