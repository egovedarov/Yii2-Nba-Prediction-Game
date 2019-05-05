<?php

namespace app\controllers;


use app\models\UserModel;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class SessionController extends Controller
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
                            'actions' => ['login'],
                            'roles' => ['?']
                        ]
                    ]
                ]
            ], parent::behaviors());
    }

    public function actionLogin(
        Request $request
    )
    {
        $userModelParams = $request->getBodyParam('UserModel');

        $userModel = new UserModel();
        $userModel->scenario = UserModel::SCENARIO_LOGIN;

        if (empty($userModelParams)) {
            return $this->render('login', ['model' => $userModel]);
        }

        if ($userModel->load($request->bodyParams) && $userModel->validate() && $userModel->runLogin()) {
            return $this->redirect('/site/index');
        }

        return $this->render('login', ['model' => $userModel]);
    }
}