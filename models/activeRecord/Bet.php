<?php

namespace app\models\activeRecord;

use app\models\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * Class Bet
 * @package app\models\activeRecord
 *
 * @property int $id
 * @property int $prediction
 * @property int $game_id
 * @property int $user_id
 * @property string $status
 * @property boolean $is_correct
 * @property Game $game
 * @property User $user
 */
class Bet extends ActiveRecord
{
    public const STATUS_UNSCORED = 'unscored';
    public const STATUS_SCORED = 'scored';

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->status = $this->status ?? self::STATUS_UNSCORED;

        return true;
    }


    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getGame(): ActiveQuery
    {
        return $this->hasOne(Game::class, ['id' => 'game_id']);
    }
}