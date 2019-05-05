<?php

namespace app\controllers;

use app\components\BetsService;
use app\components\BetsStatistics;
use app\models\activeRecord\Game;
use app\models\activeRecord\User;
use app\models\search\BetSearchModel;
use app\models\search\UserSearchModel;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\Session;
use yii\web\User as UserComponent;

class BetsController extends Controller
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
                            'actions' => ['home-win', 'visitor-win', 'history', 'ranking'],
                            'roles' => ['@']
                        ]
                    ]
                ]
            ], parent::behaviors());
    }

    public function actionHistory(
        UserComponent $user,
        BetsStatistics $statistics
    )
    {
        /** @var User $identity */
        $identity = $user->identity;

        $betSearchModel = new BetSearchModel();
        $dataProvider = $betSearchModel->getDataProvider($identity);

        return $this->render('history', ['dataProvider' => $dataProvider]);
    }

    public function actionHomeWin(
        Request $request,
        UserComponent $user,
        Session $session,
        BetsService $betsService
    )
    {
        /** @var User $identity */
        $identity = $user->identity;

        $gameId = $request->getQueryParam('id');

        if (empty($gameId)) {
            $session->setFlash('error', 'You have not specified a game id.');

            return $this->redirect('/games/today');
        }

        $game = Game::findOne(['id' => $gameId]);

        if (empty($game)) {
            $session->setFlash('error', 'No game with such id was found.');

            return $this->redirect('/games/today');
        }

        $betsService->betHomeWin($gameId, $identity->id);

        return $this->redirect(['/games/today', '#' => $game->id]);
    }

    public function actionRanking()
    {
        $userSearchModel = new UserSearchModel();
        $dataProvider = $userSearchModel->getDataProvider();

        return $this->render('ranking', ['dataProvider' => $dataProvider]);
    }

    public function actionVisitorWin(
        Request $request,
        UserComponent $user,
        Session $session,
        BetsService $betsService
    )
    {
        /** @var User $identity */
        $identity = $user->identity;

        $gameId = $request->getQueryParam('id');

        if (empty($gameId)) {
            $session->setFlash('error', 'You have not specified a game id.');

            return $this->redirect('/games/today');
        }

        $game = Game::findOne(['id' => $gameId]);

        if (empty($game)) {
            $session->setFlash('error', 'No game with such id was found.');

            return $this->redirect('/games/today');
        }

        $betsService->betVisitorWin($gameId, $identity->id);

        return $this->redirect(['/games/today', '#' => $game->id]);
    }
}