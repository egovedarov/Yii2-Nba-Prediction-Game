<?php

namespace app\components;

use app\models\activeRecord\Game;
use app\models\activeRecord\PastGame;

class GameService
{
    const RESULT_GAME_TEMPLATE_URL2 = "http://data.nba.net/json/cms/noseason/game/20190309/0021800986/boxscore.json";
    const RESULT_GAME_TEMPLATE_URL = "http://data.nba.net/json/cms/noseason/game/%s/00%d/boxscore.json";

    /**
     * @return array
     * @throws \Exception
     */
    public function getTodaysGames(): array
    {
        $json = file_get_contents('http://data.nba.net/json/cms/2018/league/nba_games.json');
        $json = str_replace('"id":0', '"id":1', $json);
        $obj = json_decode($json, true);

        $gamesArray = $obj['sports_content']['schedule']['game'];
        $games = array();
        $date = new \DateTime();
        $interval = new \DateInterval('PT5H');
        $interval->invert = 1;
        $date->add($interval);

        foreach ($gamesArray as $gameArray) {
            $gameArray = ['Game' => $gameArray];
            $game = new Game();
            $game->load($gameArray);
            if (substr($game->dt, 0, 10) == $date->format('Y-m-d')) {
                $games[] = $game;
            }
        }

        return $games;
    }

    /**
     * @param int $daysToRemove
     * @return array
     * @throws \Exception
     */
    public function getPreviousDayGames(int $daysToRemove = 1): array
    {
        $json = file_get_contents('http://data.nba.net/json/cms/2018/league/nba_games.json');
        $json = str_replace('"id":0', '"id":1', $json);
        $obj = json_decode($json, true);

        $gamesArray = $obj['sports_content']['schedule']['game'];
        $games = array();
        $date = new \DateTime();
        $interval = new \DateInterval(sprintf('P%dD', $daysToRemove));
        $date->sub($interval);

        foreach ($gamesArray as $gameArray) {
            $gameArray = ['Game' => $gameArray];
            $game = new Game();
            $game->load($gameArray);
            if (substr($game->dt, 0, 10) == $date->format('Y - m - d')) {
                $games[] = $game;
            }
        }

        return $games;
    }

    /**
     * @param array $games
     */
    public function saveGames(array $games)
    {
        foreach ($games as $game) {
            if (!Game::find()->where(['id' => $game->id])->exists()) {
                $game->save();
            }
        }
    }

    public function updateScores(): void
    {
        $games = Game::findAll(['winner' => null]);

        foreach ($games as $game) {

            $date = substr($game->dt, 0, 10);
            $date = str_replace('-', '', $date);

            $json = file_get_contents(sprintf(self::RESULT_GAME_TEMPLATE_URL, $date, $game->id));
            $obj = json_decode($json, true);
            $gameArray = $obj['sports_content']['game'];

            if (empty($gameArray['visitor']['score'])) {
                continue;
            }

            $game->v_team_score = $gameArray['visitor']['score'];
            $game->h_team_score = $gameArray['home']['score'];
            $game->winner = $game->v_team_score > $game->h_team_score ? 1 : 2;
            $game->save();
        }
    }
}