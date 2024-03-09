<?php

namespace frontend\components;

use yii\web\Controller;

class BaseController extends Controller
{

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['userFilter'] = [
            'class' => UserLoaderFilter::class
        ];

        return $behaviors;
    }
}