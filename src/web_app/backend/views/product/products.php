    <?php

use common\models\Type;
use common\widgets\Navigation;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var $products ActiveDataProvider
 */
$this->title = 'Products Admin  »  Sportify';

echo $this->render('/site/common/_alert');

$types = Type::getAll();
$tabs = [];
$tabs = array_merge($tabs, [
    'all' => [
        'link' => Url::to(['/products']),
        'site' => 'All'
    ],
    'active' => [
        'link' => Url::to(['/products?is_activated=1&tab=active']),
        'site' => 'Active'
    ],
    'inactive' => [
        'link' => Url::to(['/products?is_activated=0&tab=inactive']),
        'site' => 'Inactive'
    ]
]);
foreach ($types as $type) {
    $tabs = array_merge($tabs, [
            $type->name => [
                'link' => Url::to(["/products?type[]=$type->name&tab=$type->name"]),
                'site' => ucfirst($type->name)
            ]
    ]);
}
$tab = $tabs[Yii::$app->request->get('tab')]['site'] ?? 'All';
?>

<div class="container">
    <div class="mb-5">
        <?php echo Navigation::widget([
            'tabs' => $tabs,
            'tab' => $tab,
        ]); ?>
    </div>
    <div id="settings-container">
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