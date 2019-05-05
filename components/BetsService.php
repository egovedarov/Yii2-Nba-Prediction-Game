<?php

namespace app\components;

use app\models\activeRecord\Bet;
use app\models\activeRecord\User;

class BetsService
{
    /**
     * @param int $gameId
     * @param int $userId
     * @return bool
     */
    public function betHomeWin(int $gameId, int $userId): bool
    {
        $bet = Bet::findOne(['game_id' => $gameId, 'user_id' => $userId]);
        if (empty($bet)) {
            $bet = new Bet();
            $bet->game_id = $gameId;
            $bet->user_id = $userId;
        }

        $bet->prediction = 2;
        return $bet->save();
    }

    /**
     * @param int $gameId
     * @param int $userId
     * @return bool
     */
    public function betVisitorWin(int $gameId, int $userId): bool
    {
        $bet = Bet::findOne(['game_id' => $gameId, 'user_id' => $userId]);
        if (empty($bet)) {
            $bet = new Bet();
            $bet->game_id = $gameId;
            $bet->user_id = $userId;
        }

        $bet->prediction = 1;
        return $bet->save();
    }

    public function updateBets()
    {
        $bets = Bet::findAll(['status' => Bet::STATUS_UNSCORED]);

        foreach ($bets as $bet) {
            $winner = $bet->game->winner;

            if ($winner === null) {
                continue;
            }

            $transaction = Bet::getDb()->beginTransaction();

            $user = User::findOne(['id' => $bet->user_id]);
            if ($winner == $bet->prediction) {
                $user->score++;
                $user->save();
                $bet->is_correct = true;
            } else {
                $bet->is_correct = false;
            }

            $bet->status = Bet::STATUS_SCORED;
            $bet->save();

            $transaction->commit();
        }
    }
}