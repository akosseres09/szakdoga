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
        <div class="mb-3 form-floating">
            <input type="search" class="form-control" id="filter-search" placeholder="Search">
            <label for="filter-search">Search</label>
        </div>
        <?php $form = ActiveForm::begin([
            'id' => 'shop-filter-form',
            'action' => '/shop/products'
        ]); ?>
        <div class="accordion accordion-flush" id="formFilterAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        Product
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                    <div class="accordion-body">

                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                        Type
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                    <div class="accordion-body">
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        Price
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                    <div class="accordion-body">
                    </div>
                </div>
            </div>
        </div>
        <?= Html::submitButton('Filter', ['class' => 'btn btn-primary mt-3']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-lg-9 shop-container-search-bar py-3" style="border-radius: 10px;background-color: var(--spfy-background-color)">
        <div class="shop-container">
            <?= $content ?>
        </div>
    </div>
</div>

<?php
$this->endContent();