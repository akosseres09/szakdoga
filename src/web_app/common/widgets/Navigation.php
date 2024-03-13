<?php

namespace common\widgets;

use yii\base\Widget;

class Navigation extends Widget
{
    public array $tabs;
    public string $tab;

    public function init(): void
    {
        parent::init();
    }

    public function run(): void
    {
        echo \Yii::$app->view->renderFile('@frontend/views/common/_navigation.php', [
            'tabs' => $this->tabs,
            'tab' => $this->tab
        ]);
    }


}