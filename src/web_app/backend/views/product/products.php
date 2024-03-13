<?php

use backend\assets\AppAsset;
use common\widgets\Navigation;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\View;

/**
 * @var View $this
 * @var $products ActiveDataProvider
 */
$this->registerCssFile('/css/account/account.css');
$this->registerJsFile('/js/account/account.js', ['depends' => [JqueryAsset::class, AppAsset::class]]);
$this->title = 'Products Admin  »  Sportify';

echo $this->render('/site/common/_alert');

$tabs = [
    'all' => [
        'link' => Url::to(['/product']),
        'site' => 'All'
    ],
    'footballShoes' => [
        'link' => Url::to(['/product?typeName[]=Indoor Football Shoes&typeName[]=Outdoor Football Shoes']),
        'site' => 'Football Shoes'
    ],
    'handballShoes' => [
        'link' => Url::to(['/product?typeName[]=Handball Shoes']),
        'site' => 'Handball Shoes'
    ],
    'basketballShoes' => [
        'link' => Url::to(['/product?typeName[]=Basketball Shoes']),
        'site' => 'Basketball Shoes'
    ],
    'shoes' => [
        'link' => Url::to(['/product?typeName[]=Shoes']),
        'site' => 'Shoes',
    ],
    'accessories' => [
        'link' =>  Url::to(['/product?typeName[]=Accessories']),
        'site' => 'accessories',
    ],
    'active' => [
        'link' => Url::to(['/product?is_activated=1']),
        'site' => 'Active'
    ],
    'inactive' => [
        'link' => Url::to(['/product?is_activated=0']),
        'site' => 'Inactive'
    ],
    'shirts' => [
        'link' => Url::to(['/product?typeName[]=Shirt']),
        'site' => 'Shirts'
    ]
];

?>

<div class="container">
    <div class="mb-5">
        <?php echo Navigation::widget([
            'tabs' => $tabs,
            'tab' => 'All'
        ]); ?>
    </div>
    <div id="product-container">
        <?=
            $this->render('_listView', [
                'products' => $products
            ])
        ?>
    </div>
</div>
<a class="position-fixed add-new-btn" id="addModalToggler" data-bs-target="#addModal" data-bs-toggle="modal">
    <span class="material-symbols-outlined">
        add
    </span>
</a>

<div id="addModal" class="modal modal-lg fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
    </div>
</div>

<div id="productEditModal" class="modal modal-lg fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
    </div>
</div>