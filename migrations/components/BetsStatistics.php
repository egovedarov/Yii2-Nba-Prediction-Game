<?php

namespace app\components;

use app\models\activeRecord\Bet;
use app\models\activeRecord\Game;
use app\models\activeRecord\NbaTeam;
use yii\helpers\ArrayHelper;

/**
 * Class BetsStatistics
 * @package app\models
 */
class BetsStatistics
{
    /**
     * @return array
     */
    public function getCorrectBets(): array
    {
        $bets = Bet::findAll(['is_correct' => true]);
        return $bets;
    }

    /**
     * @return float
     */
    public function getPredictionPercentage(): float
    {
        $allBetsAmount = Bet::find()->count();
        return round(sizeof($this->getCorrectBets()) / $allBetsAmount, 2);
    }

    /**
     * @return array
     */
    public function getPredictionStatisticsPerTeam(): array
    {
        $correctBets = $this->getCorrectBets();
        $correctPredictionsPerTeam = array();

        foreach ($correctBets as $correctBet) {
            /** @var Game $game */
            $game = $correctBet->game;
            if ($game->winner === 1) {
                if (isset($correctPredictionsPerTeam[$game->v_abrv])) {
                    $correctPredictionsPerTeam[$game->v_abrv]++;
                } else {
                    $correctPredictionsPerTeam[$game->v_abrv] = 1;
                }
            } else {
                if (isset($correctPredictionsPerTeam[$game->h_abrv])) {
                    $correctPredictionsPerTeam[$game->h_abrv]++;
                } else {
                    $correctPredictionsPerTeam[$game->h_abrv] = 1;
                }
            }
        }

        $teams = NbaTeam::find()->all();
        foreach ($teams as $team) {
            if (!isset($correctPredictionsPerTeam[$team->abbreviation])) {
                $correctPredictionsPerTeam[$team->abbreviation] = 0;
            }
        }

        arsort($correctPredictionsPerTeam);

        $result = array();

        foreach ($correctPredictionsPerTeam as $teamAbbreviation => $correctPredictionPerTeam) {
            $result[$teamAbbreviation] = [
                'correct' => $correctPredictionPerTeam,
                'all' => $correctPredictionPerTeam,
                'percentage' => $correctPredictionPerTeam === 0 ? 0 : 1
            ];
        }

        $wrongBets = $this->getWrongBets();

        foreach ($wrongBets as $wrongBet) {
            /** @var Game $game */
            $game = $wrongBet->game;

            if ($game->winner === 1) {
                $statsVisitorTeam = $result[$game->h_abrv];
                if (isset($statsVisitorTeam['correct'])) {
                    $statsVisitorTeam['all']++;
                    $statsVisitorTeam['percentage'] = $statsVisitorTeam['correct'] / $statsVisitorTeam['all'];
                }

                $result[$game->h_abrv] = $statsVisitorTeam;
            } else {
                $statsHomeTeam = $result[$game->v_abrv];
                if (isset($statsHomeTeam['correct'])) {
                    $statsHomeTeam['all']++;
                    $statsHomeTeam['percentage'] = $statsHomeTeam['correct'] / $statsHomeTeam['all'];
                }

                $result[$game->v_abrv] = $statsHomeTeam;
            }
        }

        $dataProviderStats = array();
        foreach ($result as $abbreviation => $stats) {
            $dataProviderStats[] = ArrayHelper::merge(
                ['abbreviation' => $abbreviation],
                $stats
            );
        }

        usort($dataProviderStats, function ($a, $b) {
            if ($a['percentage'] === $b['percentage']) {
                return $a['all'] <= $b['all'];
            }

            return $a['percentage'] < $b['percentage'];
        });

        return $dataProviderStats;
    }

    /**
     * @return array
     */
    public function getWrongBets(): array
    {
        $bets = Bet::findAll(['is_correct' => false]);
        return $bets;
    }
}