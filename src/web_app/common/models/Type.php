<?php

namespace common\models;

use common\models\query\TypeQuery;
use Yii;
use yii\base\Event;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $product_type
 */
class Type extends ActiveRecord
{
    const TYPE_CACHE_KEY = 'type';
    const TYPE_ALL = 'typeAll';

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_INSERT, [Type::class, 'clearCache']);
        $this->on(self::EVENT_BEFORE_DELETE, [Type::class, 'clearCache']);
        $this->on(self::EVENT_AFTER_UPDATE, [Type::class, 'clearCache']);
    }

    public static function tableName(): string
    {
        return '{{%type}}';
    }

    public function rules(): array
    {
        return [
            [['product_type'], 'required'],
            [['product_type'], 'string', 'max' => 128]
        ];
    }

    public function behaviors()
    {
        return [];
    }

    public static function find(): TypeQuery
    {
        return new TypeQuery(get_called_class());
    }

    public static function clearCache(Event $event): void
    {
        static::deleteCache(static::getCacheKey());
    }

    public static function deleteCache(mixed $key): void
    {
        Yii::$app->cache->delete($key);
    }

    public static function getCacheKey(): string
    {
        return self::TYPE_ALL;
    }

    public static function getAll()
    {
        return Yii::$app->cache->getOrSet(static::getCacheKey(), function () {
            return Type::find()->all();
        }, 60 * 60 * 4);
    }

}