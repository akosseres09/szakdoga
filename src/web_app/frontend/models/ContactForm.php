<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $email;
    public $subject;
    public $body;
    public $captcha;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            // name, email, subject and body are required
            [['email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['captcha', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'email' => 'Your email address',
            'body' => 'Description',
            'captcha' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail(string $email): bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'contactUs-html', 'text' => 'contactUs-text'],
                ['form' => $this]
            )
            ->setTo(Yii::$app->params['adminEmail'])
            ->setFrom($email)
            ->setSubject($this->subject)
            ->send();
    }
}
