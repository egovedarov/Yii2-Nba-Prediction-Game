<?php

namespace app\models\search;


use app\models\activeRecord\Game;
use yii\data\ActiveDataProvider;

class GameSearchModel extends Game
{
    public function getDataProvider($daysToSubtract = 0): ActiveDataProvider
    {
        $date = new \DateTime();
        $interval = new \DateInterval(sprintf('P%dD', $daysToSubtract));
        $date->sub($interval);

        $query = Game::find()->where(['like', 'dt', $date->format('Y-m-d')])->orderBy(['dt' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}