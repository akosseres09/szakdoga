<?php

namespace frontend\models;

use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use Yii;
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $rePassword;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['rePassword', 'trim'],
            ['password', 'trim'],
            [['password', 'rePassword'], 'required'],
            [['password', 'rePassword'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['rePassword', 'compare', 'compareAttribute' => 'password', 'skipOnError' => false,'message' => 'Passwords do not match']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'rePassword' => 'Password Again'
        ];
    }

    public static function samePws() {

    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     * @throws Exception
     */
    public function resetPassword(): bool
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        $user->generateAuthKey();

        return $user->save(false);
    }
}
