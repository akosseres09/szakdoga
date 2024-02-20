<?php

namespace console\controllers;

use common\components\File;
use yii\console\Controller;

class RemoveProductController extends Controller
{
    public function actionRemoveImages(): void
    {
        if (File::rrmdir(\Yii::getAlias('@frontend/web/storage/images'))) {
            echo "Deleted images!";
        } else {
            echo "Failed to delete images";
        }
    }

    public function actionRemoveProductImage($folderId): void
    {
        if (File::rrmdir(\Yii::getAlias('@frontend/web/storage/images/'.$folderId))) {
            echo "Deleted images!\n";
        } else {
            echo "Failed to delete images!\n";
        }
    }
}