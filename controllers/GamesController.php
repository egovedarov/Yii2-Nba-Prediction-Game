<?php

namespace app\controllers;

use app\models\search\GameSearchModel;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\User as UserComponent;

class GamesController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge([
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['today', 'previous'],
                        'roles' => ['@']
                    ]
                ]
            ]
        ], parent::behaviors());
    }

    public function actionPrevious(
        Request $request
    )
    {
        $daysToSubtract = $request->getQueryParam('daysToSubtract');

        if (empty($daysToSubtract)) {
            $daysToSubtract = 1;
        }

        $gameSearchModel = new GameSearchModel();
        $dataProvider = $gameSearchModel->getDataProvider($daysToSubtract);

        return $this->render('previous', ['dataProvider' => $dataProvider, 'daysToSubtract' => $daysToSubtract]);
    }

    public function actionToday(
        UserComponent $user
    )
    {
        $gameSearchModel = new GameSearchModel();
        $dataProvider = $gameSearchModel->getDataProvider();

        return $this->render('today', ['dataProvider' => $dataProvider, 'userId' => $user->identity->id]);
    }
}