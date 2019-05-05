<?php

namespace app\models\activeRecord;

use app\models\ActiveRecord;
use yii\db\ActiveQuery;
use yii\validators\SafeValidator;

/**
 * Class Game
 * @package app\models
 *
 * @property string $h_abrv
 * @property string $v_abrv
 * @property int $id
 * @property string $dt
 * @property string $r_reg
 * @property bool $is_lp
 * @property bool $sg
 * @property int $h_team_score
 * @property int $v_team_score
 * @property int $winner
 * @property Bet[] $bets
 */
class Game extends ActiveRecord
{
    /**
     * @return ActiveQuery
     */
    public function getBets(): ActiveQuery
    {
        return $this->hasMany(Bet::class, ['game_id' => 'id']);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['h_abrv', 'v_abrv', 'id', 'dt', 'r_reg', 'is_lp', 'sg'], SafeValidator::class]
        ];
    }
}