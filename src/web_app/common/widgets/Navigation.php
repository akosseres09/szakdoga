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
        echo $this->render('/common/_navigation', [
            'tabs' => $this->tabs,
            'tab' => $this->tab
        ]);
    }


}