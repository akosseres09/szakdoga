<?php

namespace common\models;

use common\models\query\BrandQuery;
use Yii;
use yii\base\Event;
use yii\db\ActiveRecord;

/**
 * @property string $name
 */

class Brand extends ActiveRecord
{

    public function init(): void
    {
        parent::init();

        $this->on(self::EVENT_AFTER_INSERT, [Brand::class, 'clearCache']);
        $this->on(self::EVENT_BEFORE_DELETE, [Brand::class, 'clearCache']);
        $this->on(self::EVENT_AFTER_UPDATE, [Brand::class, 'clearCache']);
    }

    const BRAND_CACHE_KEY = 'brand';
    const BRAND_ALL = 'brandAll';
    public static function tableName(): string
    {
        return '{{%brand}}';
    }

    public function behaviors(): array
    {
        return [];
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128]
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'Id',
            'name' => 'Brand Name'
        ];
    }

    public static function find(): BrandQuery
    {
        return new BrandQuery(get_called_class());
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
        return self::BRAND_ALL;
    }

    public static function getAll()
    {
        return Yii::$app->cache->getOrSet(static::getCacheKey(), function () {
            return Brand::find()->all();
        }, 60 * 60 * 4);
    }


}