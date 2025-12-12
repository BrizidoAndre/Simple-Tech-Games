<?php

namespace app\controllers;

use app\bases\ErrorNoHeader;
use app\models\Admin;
use app\models\Games;
use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
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
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorNoHeader::class,
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
     * @return string
     */
    public function actionIndex($month = null)
    {
        $games = Games::find()
            ->select(['games.*', 'count(st.id) as popCount'])
            ->joinWith('solutions st')
            ->groupBy('games.id')
            ->orderBy(new Expression('valid_date desc'))
            ->limit(3)->all();
        $admin = Admin::find()->joinWith('user');
        $admin->andWhere(['first_acess' => 1]);
        $admin->orderBy('created_at desc');
        $adminProvider = new ActiveDataProvider([
            'query' => $admin,
        ]);
        $gamesPopular = Games::find()->addSelect('games.*, count(st.id) as popCount')
            ->joinWith('solutions st')
            ->groupBy('games.id')
            ->orderBy('popCount desc')
            ->limit(3)
            ->all();

        return $this->render('home', [
            'games' => $games,
            'adminProvider' => $adminProvider,
            'gamesPopular' => $gamesPopular,
            'month' => $month,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
