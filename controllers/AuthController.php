<?php

namespace app\controllers;

use app\models\Admin;
use app\models\FirstAccess;
use app\models\LoginForm;
use app\models\Solution;
use app\models\Users;
use app\models\UsersPassword;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AuthController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'except' => ['login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionLogin()
    {
        Yii::$app->params['header'] = false;
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

    public function actionNewUser()
    {
        $success = false;
        $user = new Users();
        $link = null;
        if ($this->request->isPost) {
            $user->load($this->request->post());
            if ($user->save()) {
                $admin = new Admin([
                    'user_id' => $user->id,
                    'first_acess' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $admin->save(false);
                $link = new FirstAccess([
                    'admin_id' => $admin->id,
                    'link' => \Yii::$app->security->generateRandomString(10),
                    'created_at' => time() + (60 * 60),
                ]);
                $link->save(false);
                \Yii::$app->session->setFlash('success', 'Criado com sucesso');
                $success = true;
            }
        } else {
            $user->loadDefaultValues();
        }

        return $this->render('new-user', [
            'model' => $user,
            'success' => $success,
            'link' => $link,
        ]);
    }

    public function actionUsers($players = false)
    {
        $query = Users::find();
        if ($players) {
            $query->with('players');
            $query->andWhere(['is_admin' => 0]);
        } else {
            $query->with('admins');
            $query->andWhere(['is_admin' => 1]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('users', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionFirstAccess($link)
    {
        $access = FirstAccess::find()
            ->andWhere(['link' => $link])
            ->andWhere(['>', 'created_at', time()])->one();
        if (!$access) {
            throw new NotFoundHttpException('Link não encontrado');
        }

        $passwordModel = new UsersPassword();
        if ($this->request->isPost) {
            $passwordModel->load($this->request->post());
            if ($passwordModel->validate()) {
                $admin = $access->admin;
                $admin->first_acess = 0;
                $admin->save(false);
                $user = $admin->user;
                $user->password = md5($passwordModel->password);
                $user->save(false);
                $this->redirect(['admin/login']);
            }
        }
        return $this->render('first-access', [
            'model' => $passwordModel,
        ]);
    }

    public function actionView($id, $access = false)
    {
        $model = Users::findOne($id);
        $link = null;
        if (!$model) {
            throw new NotFoundHttpException('Não encontrado');
        }
        if ($model->is_admin) {
            if ($access) {
                $link = new FirstAccess([
                    'admin_id' => $model->admins->id,
                    'link' => \Yii::$app->security->generateRandomString(10),
                    'created_at' => time() + (60 * 60),
                ]);
                $link->save(false);
                \Yii::$app->session->setFlash('success', 'Criado com sucesso');
            }
            return $this->render('single-admin', [
                'model' => $model,
                'link' => $link,
            ]);
        }

        return $this->render('single-player', [
            'model' => $model
        ]);
    }

    public function actionPlayerDelete($id)
    {
        $model = Users::findOne($id);
        $player = $model->players;
        $player->deleted = 1;
        $player->save(false);
        Solution::deleteAll(['player_id' => $player->id]);
        return $this->goBack();
    }
}
