<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use src\forms\auth\LoginForm;
use src\forms\auth\PasswordResetRequestForm;
use src\forms\auth\ResetPasswordForm;
use src\forms\auth\SignupForm;
use src\forms\contact\ContactForm;
use src\services\SignupService;
use src\services\PasswordResetService;

/**
 * Site controller
 */
class SiteController extends Controller
{

    private $passwordResetService;
    private $signupService;

    /**
     * SiteController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param PasswordResetService $passwordResetService идет автозагрузка из контейнера внедрения зависимостями
     * @param SignupService $signupService
     * @param array $config
     */
    public function __construct($id, $module,
                                PasswordResetService $passwordResetService,
                                SignupService $signupService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->passwordResetService = $passwordResetService;
        $this->signupService = $signupService;
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Account activate
     */
    public function actionAccountActivate($token)
    {
        try {
            $this->passwordResetService->validateToken($token);
        }
        catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $form = new ResetPasswordForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate())
        {
            try {
                $this->passwordResetService->reset($token, $form);
                Yii::$app->session->setFlash('success', 'User is Activate.');

            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        //$service = new SignupService();

        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {


            $user = $this->signupService->signup($form);

            try{
                $this->signupService->sendEmail($user);
                Yii::$app->session->setFlash('success', 'You have been sent a message to'. $user->email);
            } catch (\RuntimeException $e)
            {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

            if (Yii::$app->getUser()->login($user)) {
                return $this->goHome();
            }

        }

        return $this->render('signup', [
            'model' => $form,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try
            {
                $this->passwordResetService->request($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }
            catch (\RuntimeException $e)
            {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $form,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {

        try {
            $this->passwordResetService->validateToken($token);
        }
        catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $form = new ResetPasswordForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate())
        {
            try {
                $this->passwordResetService->reset($token, $form);
                Yii::$app->session->setFlash('success', 'New password saved.');

            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('resetPassword', [
            'model' => $form,
        ]);
    }
}
