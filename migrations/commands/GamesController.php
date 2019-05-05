<?php

namespace app\commands;


use app\components\GameService;

class GamesController extends Controller
{
    /**
     * @param GameService $gameService
     * @throws \Exception
     */
    public function actionGetTodayGames(
        GameService $gameService
    )
    {
        $games = $gameService->getTodaysGames();
        $gameService->saveGames($games);
    }

    /**
     * @param GameService $gameService
     * @throws \yii\db\Exception
     */
    public function actionUpdateScores(
        GameService $gameService
    )
    {
        $gameService->updateScores();
    }
}