<?php

namespace app\controllers;


use app\models\BetsStatistics;
use app\models\UserModel;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class UsersController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => [
                                'register',
                            ],
                            'roles' => ['?']
                        ],
                        [
                            'allow' => true,
                            'actions' => [
                                'profile'
                            ],
                            'roles' => ['@']
                        ]
                    ]
                ]
            ], parent::behaviors());
    }

    public function actionRegister(
        Request $request
    )
    {
        $userModelParams = $request->getBodyParam('UserModel');

        $userModel = new UserModel();
        $userModel->scenario = UserModel::SCENARIO_REGISTER;

        if (empty($userModelParams)) {
            return $this->render('register', ['model' => $userModel]);
        }

        if ($userModel->load($request->bodyParams) && $userModel->validate() && $userModel->runRegister()) {
            return $this->redirect('/site/index');
        }

        return $this->render('register', ['model' => $userModel]);
    }

    public function actionProfile(
        BetsStatistics $statistics
    )
    {
        $predictionsPerTeam = $statistics->getPredictionStatisticsPerTeam();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $predictionsPerTeam,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        return $this->render('stats', ['dataProvider' => $dataProvider]);
    }
}