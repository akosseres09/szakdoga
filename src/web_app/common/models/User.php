<?php

namespace common\models;

use common\models\query\UserQuery;
use Yii;
use yii\base\Event;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $is_admin
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 * @property string $verification_token
 * @property integer $last_login_at
 * @property string $stripe_cus
 * @property string $password write-only password
 *
 * @property BillingInformation|null $billingInformation
 * @property ShippingInformation|null $shippingInformation
 * @property Cart[]|null $cartItems
 * @property Wishlist[]|null $wishlistItems
 * @property Rating[]|null $ratings
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const ADMIN = 1;
    const USER = 0;

    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive'
    ];

    const ROLES = [
        self::ADMIN => 'Admin',
        self::USER => 'User'
    ];

    const USER_CACHE_KEY = 'User';

    public function init(): void
    {
        parent::init();

        $this->on(self::EVENT_AFTER_INSERT, [static::class, 'clearCache']);
        $this->on(self::EVENT_BEFORE_DELETE, [static::class, 'clearCache']);
        $this->on(self::EVENT_AFTER_UPDATE, [static::class, 'clearCache']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'password_reset_token','auth_key','email'], 'unique'],
            [['auth_key', 'username', 'password_hash','email'], 'required'],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'email'],
            [['email', 'password_hash', 'username', 'password_reset_token', 'verification_token'],'string', 'max' => 255],
            [['is_admin'], 'default', 'value' => self::USER],
            [['is_admin'], 'in', 'range' => [self::USER, self::ADMIN]],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['created_at', 'updated_at', 'last_login_at', 'deleted_at'], 'integer']
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'id' => 'Id',
            'username' => 'Username',
            'email' => 'Email',
            'is_admin' => 'Role',
            'status' => 'Status',
        ];
    }

    public function getBilling(): ActiveQuery
    {
        return $this->hasOne(BillingInformation::class, ['user_id' => 'id']);
    }

    public function getShipping(): ActiveQuery
    {
        return $this->hasOne(ShippingInformation::class, ['user_id' => 'id']);
    }

    public function getCartItems(): ActiveQuery
    {
        return $this->hasMany(Cart::class, ['user_id' => 'id']);
    }

    public function getWishlistItems(): ActiveQuery
    {
        return $this->hasMany(Wishlist::class, ['user_id' => 'id']);
    }

    public function getRatings(): ActiveQuery
    {
        return $this->hasMany(Rating::class, ['user_id' => 'id']);
    }

    public static function find(): UserQuery
    {
        return new UserQuery(get_called_class());
    }

    public static function clearCache(Event $event): void
    {
        $user = $event->sender;

        static::deleteCache(static::getCacheKey($user->id));
    }

    public static function deleteCache(mixed $key): void
    {
        Yii::$app->cache->delete($key);
    }

    public static function getCacheKey(int $id): string
    {
        return self::USER_CACHE_KEY . $id;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): User|IdentityInterface|null
    {
        return Yii::$app->cache->getOrSet(static::getCacheKey($id), function () use ($id) {
            return static::findOne(
                [
                    'id' => $id,
                    'status' => self::STATUS_ACTIVE,
                    'deleted_at' => null
                ]
            );
        }, 60 * 60 * 4);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username): ?User
    {
        return static::findOne([
            'username' => $username,
            'status' => self::STATUS_ACTIVE,
            'deleted_at' => null
        ]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string|null $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken(string $token = null): ?User
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
            'deleted_at' => null
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken(string $token): ?User
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE,
            'deleted_at' => null
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     * @throws Exception
     */
    public function generateEmailVerificationToken(): void
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    public function getProfilePic(): string
    {
        return Yii::$app->params['frontendUrl'] . '/storage/profile-pics/default_pic.jpg';
    }

    public function hasBillingInfo(): bool
    {
        return $this->getBilling()->exists();
    }

    public function hasShippingInfo(): bool
    {
        return $this->getShipping()->exists();
    }

    public function getCartCount(): int
    {
        return count($this->cartItems);
    }

    public function getWishlistCount(): int
    {
        return count($this->wishlistItems);
    }

    public function getRole(): string
    {
        return self::ROLES[$this->is_admin];
    }

    public function getStatus(): string
    {
        return self::STATUSES[$this->status];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === 1;
    }

    public function isDeleted(): bool
    {
        return $this->deleted_at !== null;
    }

}
