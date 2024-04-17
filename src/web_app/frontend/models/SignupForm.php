<?php

namespace frontend\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $passwordAgain;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255, 'message' => 'Username must be between 2 and 255 characters long'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email', 'message' => 'This email is not a valid email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['passwordAgain', 'trim'],
            ['passwordAgain', 'required'],
            ['passwordAgain', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['password', 'compare', 'compareAttribute' => 'passwordAgain', 'skipOnError' => false, 'message' => 'Passwords do not match'],
            ['passwordAgain', 'compare', 'compareAttribute' => 'password', 'skipOnError' => false,'message' => 'Passwords do not match']
        ];
    }


    /**
     * Signs user up.
     *
     * @return bool|null whether the creating new account was successful and email was sent
     * @throws Exception
     */
    public function signup(): ?bool
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be sent
     * @return bool whether the email was sent
     */
    protected function sendEmail(User $user): bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Sportify robot'])
            ->setTo($this->email)
            ->setSubject('Verify Your Account')
            ->send();
    }
}
