<?php

namespace app\models\search;

use app\models\activeRecord\Bet;
use app\models\activeRecord\User;
use yii\data\ActiveDataProvider;

class BetSearchModel extends Bet
{
    public function getDataProvider(User $user): ActiveDataProvider
    {
        $query = Bet::find()->andWhere(['user_id' => $user->id])->andWhere(['status' => self::STATUS_SCORED])->orderBy(['dt' => SORT_DESC])->joinWith(['game']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->pagination->pageSize = 10;

        return $dataProvider;
    }
}