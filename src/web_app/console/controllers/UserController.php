<?php

namespace console\controllers;

use common\models\User;
use SebastianBergmann\Type\Exception;
use yii\console\Controller;
use yii\db\StaleObjectException;

class UserController extends Controller
{
    public function actionDeactivateById(int $id)
    {
        $user = User::find()->ofId($id)->ofDeleted()->one();

        if (!$user) {
            echo "No such User with id:" . $id . PHP_EOL;
        }

        $user->deleted_at = strtotime('now');
        $user->status = User::STATUS_INACTIVE;

        if ($user->save()) {
            echo "Deactivated User with id:" . $id . PHP_EOL;
        } else {
            echo "Failed to Deactivate User with id:" . $id . PHP_EOL;
        }
    }

    public function actionDeleteById(int $id): void
    {
        $user = User::find()->ofId($id)->ofDeleted()->one();

        if (!$user) {
            echo 'No such User with id: ' . $id . PHP_EOL;
        }

        try {
            if ($user->delete()) {
                echo 'Deleted User with id: ' . $id . PHP_EOL;
            } else {
                echo 'Failed to delete User with id: ' . $id . PHP_EOL;
            }
        } catch (Exception|StaleObjectException|\Throwable $e) {
            echo 'Error while deleting user: ' . $e->getMessage() . PHP_EOL;
        }
    }

    public function actionUndoDeleteById(int $id): void
    {
        $user = User::find()->ofId($id)->ofDeleted(true)->one();

        if (!$user) {
            echo 'No such User with id: ' . $id . PHP_EOL;
        }

        $user->status = User::STATUS_ACTIVE;
        $user->deleted_at = null;

        if ($user->save()) {
            echo 'Reactivated user with id: ' . $id . PHP_EOL;
        } else {
            echo 'Failed to reactivate user with id: ' . $id . PHP_EOL;
        }
    }
}