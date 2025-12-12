<?php

namespace app\controllers;

use app\models\Games;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\UploadedFile;

class GameController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionCreate()
    {
        $model = new Games();
        // verificando se a rota é um post
        if ($this->request->isPost) {
            // se sim obtém todos os valores + a imagem
            $model->load($this->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                return $this->redirect(['admin/games']);
            }

        } else {
            $model->loadDefaultValues();
        }
        return $this->render('new-game', [
            'model' => $model
        ]);
    }

    public function actionIndex()
    {
        $query = Games::find()->orderBy('valid_date desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('games', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($date)
    {
        $game = Games::find()
            ->andWhere(['valid_date' => $date])
            ->joinWith(['pieces' => function (ActiveQuery $query) {
                $query->orderBy('position asc');
            }]);
        return $this->render('view', [
            'model' => $game->one(),
        ]);
    }
}
