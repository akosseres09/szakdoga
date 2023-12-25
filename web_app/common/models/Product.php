<?php

namespace common\models;


use common\models\query\ProductQuery;
use Imagine\Gd\Image;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property string $folder_id
 * @property int $brand_id
 * @property int type_id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property int $rating
 * @property int $number_of_stocks
 * @property bool $is_activated
 * @property int $is_kid
 * @property int $gender
 *
 * @property Type $type
 * @property Brand $brand
 * @property Rating[]|null $ratings
 */


class Product extends ActiveRecord
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    const STATUSES = [
        self::INACTIVE => 'Inactive',
        self::ACTIVE => 'Active'
    ];
    const OUT_OF_STOCK = 'Out of Stock';
    const ON_STOCK = 'On Stock';
    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    const KID = 0;
    const NOT_KID = 1;

    /**
     * @var UploadedFile[]
     */
    public array $images = [];

    public static function tableName(): string
    {
        return 'product';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false,
                'updatedAtAttribute' => false
            ]
        ];
    }

    public function rules(): array
    {
        return [
            [['name', 'description', 'price', 'number_of_stocks', 'is_kid', 'gender', 'type_id', 'brand_id', 'folder_id'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['folder_id'], 'string', 'max' => 11],
            ['description', 'string', 'max' => 1024],
            ['rating', 'in', 'range' => [0,1,2,3,4,5]],
            [['number_of_stocks'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number', 'message' => 'Stock number must be 0 or positive!'],
            [['price'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number', 'message' => 'Price must be 0 or positive!'],
            ['is_activated', 'default', 'value' => self::INACTIVE],
            ['is_activated', 'in', 'range' => [self::INACTIVE, self::ACTIVE]],
            [['is_kid'], 'in', 'range' => [self::KID, self::NOT_KID]],
            [['is_kid'], 'default', 'value' => self::NOT_KID],
            [['gender'], 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]],
            [['images'], 'image','extensions' => 'png, jpg, jpeg','maxFiles' => 5]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand Name',
            'type_id' => 'Type',
        ];
    }

    public static function find(): ProductQuery
    {
        return new ProductQuery(get_called_class());
    }

    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    public function getRating(): ActiveQuery
    {
        return $this->hasMany(Rating::class, ['id' => 'product_id']);
    }

    public function getActiveStatus(): string
    {
        return self::STATUSES[$this->is_activated];
    }

    public function getAvailability(): string
    {
        return $this->number_of_stocks === 0 ? self::OUT_OF_STOCK : self::ON_STOCK;
    }

    public function hasOnStock(): bool
    {
        return $this->number_of_stocks !== 0;
    }

    public function isShoe(): bool
    {
        return in_array($this->type, Type::find()->ofShoes()->all()) ;
    }

    public function isKid(): bool
    {
        return $this->is_kid === self::KID;
    }

    public function getImages($first = false): bool|array
    {
        $array = scandir(\Yii::getAlias('@frontend/web/storage/images/'.$this->folder_id));
        return $first ? array_slice($array,2, 1) : array_slice($array,2, count($array) - 2);
    }

    public function upload(): bool
    {
        if($this->images) {
            $imagePath = \Yii::getAlias('@frontend/web/storage/images/'.$this->folder_id);

            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0777, true);
            }

            foreach ($this->images as $image) {
                $filePath = $imagePath . '/' . $image->baseName . '.' . $image->extension;
                \yii\imagine\Image::getImagine()->open($image->tempName)
                    ->resize(new Box(500,500))
                    ->save($filePath);
            }
        }else {
            return false;
        }

        return true;
    }

    public function isActivated(): bool
    {
        return $this->is_activated;
    }

}