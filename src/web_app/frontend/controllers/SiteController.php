<?php

namespace frontend\controllers;

use frontend\models\ContactForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Stripe\Customer;
use Stripe\Stripe;
use Yii;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\captcha\CaptchaAction;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'login', 'reset-password', 'resend-verification-email', 'request-reset-password', 'verify-email', 'contact-us'],
                'rules' => [
                    [
                        'actions' => ['resend-verification-email', 'verify-email'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'request-reset-password',
                            'reset-password',
                            'login',
                            'signup',
                            'contact-us',
                        ],
                        'allow' => true,
                        'roles' => ['@', '?']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'layout' => 'mainWithoutHeaderAndFooter'
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(): string
    {
        $this->layout = 'landingPage';
        return $this->render('index');
    }

    public function actionLogin(): Response|string
    {
        $this->layout = 'mainWithoutHeaderAndFooter';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'user' => $model,
        ]);
    }


    public function actionLogout(): Response
    {
        if (Yii::$app->user->isGuest){
           return $this->goHome();
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionSignup(): Response|string
    {
        if (!Yii::$app->user->isGuest){
            $this->goHome();
        }

        $this->layout = 'mainWithoutHeaderAndFooter';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                Yii::$app->session->setFlash('Success', 'Thank you for registration. Please check your inbox for verification email.');
                return $this->redirect(['/site/login']);
            } else {
                Yii::$app->session->setFlash('Error', 'There was a problem with the signup!');
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionRequestPasswordReset(): Response|string
    {
        $this->layout = 'mainWithoutHeaderAndFooter';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                if ($model->sendEmail()) {
                    Yii::$app->session->setFlash('Success', 'Check your email for further instructions.');
                    return $this->goHome();
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('Error', 'Sorry, we are unable to reset password for the provided email address.');
                Yii::error('Failed to send an email at: ' . Yii::$app->formatter->asDate(strtotime('now')) . ' with: ' . $e->getMessage(), __METHOD__);
                return $this->goHome();
            }
            Yii::$app->session->setFlash('Error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return Response|string
     * @throws BadRequestHttpException|Exception
     */
    public function actionResetPassword(string $token): Response|string
    {
        $this->layout = 'mainWithoutHeaderAndFooter';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('Success', 'New password saved.');

            return $this->redirect('/site/login');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return Response
     * @throws BadRequestHttpException|InvalidConfigException
     */
    public function actionVerifyEmail(string $token): Response
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($model->verifyEmail())) {
            try {
                Stripe::setApiKey(Yii::$app->stripe->secretKey);
                $customer = Customer::create([
                   'email' => $model->user->email
                ]);
                $model->user->stripe_cus = $customer->id;
                if (!$model->user->save()) {
                    $customer->delete();
                }
            } catch (\Exception $e) {
                Yii::error('failed to create user at: ' . Yii::$app->formatter->asDate(strtotime('now')) . ' with: ' . $e->getMessage());
                Yii::$app->session->setFlash('error', 'Failed to create Stripe Customer!');
            }
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
        } else {
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        }

        return $this->redirect(['/site/login']);
    }

    /**
     * Resend verification email
     *
     * @return Response|string
     */
    public function actionResendVerificationEmail(): Response|string
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionContactUs(): string
    {
        $this->layout = 'mainWithoutHeaderAndFooter';
        $contactForm = new ContactForm();

        if (Yii::$app->request->isPost) {
            if ($contactForm->load(Yii::$app->request->post()) && $contactForm->validate()) {
                if ($contactForm->sendEmail($contactForm->email)) {
                    Yii::$app->session->setFlash('Success', 'Thank you for contacting us! We will respond to you as soon as possible.');
                } else {
                    Yii::$app->session->setFlash('Error', 'There was an error sending your message.');
                }
            } else {
                Yii::$app->session->setFlash('Error', 'There was an error sending your message.');
            }
        }

        $contactForm->subject = '';
        $contactForm->body = '';
        $contactForm->captcha = '';

        return $this->render('contact-us', [
            'contactForm' => $contactForm,
        ]);
    }
}
