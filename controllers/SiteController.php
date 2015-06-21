<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\MstAccount;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ChangePasswordForm;

class SiteController extends Controller
{
	public $layout='/login';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'successful'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'successful'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'], @TODO: implement POST logout
                ],
            ],
        ];
    }

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

    public function actionIndex()
    {
    	if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

    	$this->layout='/main';
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (!Yii::$app->user->identity->last_login_date
                || Yii::$app->user->identity->password === md5(Yii::$app->params['DEFAULT_PASSWORD'])) {
                $this->redirect(['site/new-password']);
            } else {
                $this->redirect(['site/successful']);
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }

    public function actionNewPassword()
    {
        $newPasswordModel = new ChangePasswordForm();
        $newPasswordParams = array();
        if (isset(Yii::$app->request->post()['ChangePasswordForm'])) {
            $newPasswordParams = Yii::$app->request->post();
            $newPasswordParams['ChangePasswordForm']['oldPassword'] = Yii::$app->params['DEFAULT_PASSWORD'];
        }

        if ($newPasswordModel->load($newPasswordParams) && $newPasswordModel->changePassword()) {
            $this->redirect(['site/successful']);
        } else {
            return $this->render('new-password', ['model' => $newPasswordModel]);
        }
    }

	public function actionChangePassword()
    {
    	$this->layout='/main';
		$changePasswordModel = new ChangePasswordForm();
		$success = false;
		if ($changePasswordModel->load(Yii::$app->request->post()) && $changePasswordModel->changePassword()) {
			$success = true;
			$changePasswordModel = new ChangePasswordForm();
		}
        return $this->render('change-password', ['model' => $changePasswordModel, 'success' => $success]);
    }

	public function actionSuccessful()
	{
		$model = Yii::$app->user->identity;

		if (null !== Yii::$app->request->post('confirm')) {
			$this->redirect(['site/index']);
		} else if(null !== Yii::$app->request->post('abort')) {
			$this->redirect(['site/logout']);
		} else {
			// display the successful page
			return $this->render('successful', ['model' => $model]);
		}
	}
}
