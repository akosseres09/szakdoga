<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Stripe\Customer;
use Stripe\Stripe;
use Yii;
use yii\base\InvalidArgumentException;
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
                'only' => ['logout', 'signup', 'login', 'request-reset-password'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login', 'request-reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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

    public function actionLogin(): \yii\web\Response|string
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


    public function actionLogout(): \yii\web\Response
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
            if($model->signup()){
                Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
                return $this->redirect(['/site/login']);
            }else {
                Yii::$app->session->setFlash('error', 'There was a problem with the signup!');
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $this->layout = 'mainWithoutHeaderAndFooter';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
     * @throws BadRequestHttpException
     */
    public function actionResetPassword(string $token): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return yii\web\Response
     *@throws BadRequestHttpException
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
                Yii::$app->session->setFlash('error', 'Failed to create Stripe Customer!');
            }
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
        }else {
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
}
