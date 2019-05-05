<?php

use app\helpers\Html;
use app\models\activeRecord\Bet;
use app\models\activeRecord\NbaTeam;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var int $userId
 */

$predictionText = 'Your prediction';

$this->title = \Yii::t('app', 'Today games');

$date = new \DateTime();
$interval = new \DateInterval('P1D');
$date->sub($interval);

echo Html::a($date->format('Y-m-d'), Url::to(['games/previous', 'daysToSubtract' => 2]), ['class' => 'btn btn-primary']);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'rowOptions' => function ($model) {
        return ['style' => 'background-color: #b0b8c4', 'id' => $model->id];
    },
    'columns' => [
        [
            'attribute' => 'v_abrv',
            'label' => 'Visitor',
            'hAlign' => 'center',
            'value' => function ($model, $key, $index, $column) use ($userId, $predictionText) {
                $nbaTeam = NbaTeam::findOne(['abbreviation' => $model->v_abrv]);

                $now = new \DateTime();

                $gameDate = new \DateTime($model->dt);
				$gameDate->add(new \DateInterval('PT5H'));

                $button = $now < $gameDate
                    ? Html::a($nbaTeam->team_name . ' Win', ['/bets/visitor-win?id=' . $model->id], ['class' => 'btn btn-primary'])
                    : '';

                $bet = Bet::findOne(['game_id' => $model->id, 'user_id' => $userId]);
                if (!empty($bet)) {
                    if ($bet->prediction == 1) {
                        if (empty($button)) {
                            $button = '<h3><b>' . $predictionText . '</b></h3><br>';
                        }
                    }
                }

                return Html::img('@web/img/' . $nbaTeam->team_name . '.png', ['height' => 200])
                    . '<br><h3><b>'
                    . $nbaTeam->team_name
                    . '</b></h3><br>'
                    . $button;
            },
            'contentOptions' => function ($model, $key, $index, $column) use ($userId) {
                $bet = Bet::findOne(['game_id' => $model->id, 'user_id' => $userId]);
                if (!empty($bet)) {
                    if ($bet->prediction == 1) {
                        return ['style' => 'background-color:#a0b78b'];
                    } else {

                    }
                }
            },
            'format' => 'html',
        ],
        [
            'attribute' => 'dt',
            'label' => 'Date',
            'hAlign' => 'center',
            'value' => function ($model, $key, $index, $column) {
                $date = new \DateTime($model->dt);
                $interval = new DateInterval('PT5H');
                $date->add($interval);
                return '<h3><b>'
                    . $date->format("d-m-Y")
                    . "<br>"
                    . $date->format('H:i')
                    . '</b></h3>';
            },
            'format' => 'html',
        ],
        [
            'attribute' => 'h_abrv',
            'label' => 'Home',
            'hAlign' => 'center',
            'value' => function ($model, $key, $index, $column) use ($userId, $predictionText) {
                $nbaTeam = NbaTeam::findOne(['abbreviation' => $model->h_abrv]);

                $now = new \DateTime();
	
				$gameDate = new \DateTime($model->dt);
				$gameDate->add(new \DateInterval('PT5H'));

                $button = $now < $gameDate
                    ? Html::a($nbaTeam->team_name . ' Win', ['/bets/home-win?id=' . $model->id], ['class' => 'btn btn-primary'])
                    : '';

                $bet = Bet::findOne(['game_id' => $model->id, 'user_id' => $userId]);
                if (!empty($bet)) {
                    if ($bet->prediction == 2) {
                        if (empty($button)) {
                            $button = '<h3><b>' . $predictionText . '</b></h3><br>';
                        }
                    }
                }

                return Html::img('@web/img/' . $nbaTeam->team_name . '.png', ['height' => 200])
                    . '<br> <h3><b>'
                    . $nbaTeam->team_name
                    . '</b></h3><br>'
                    . $button;
            },
            'contentOptions' => function ($model, $key, $index, $column) use ($userId) {
                $bet = Bet::findOne(['game_id' => $model->id, 'user_id' => $userId]);
                if (!empty($bet)) {
                    if ($bet->prediction == 2) {
                        return ['style' => 'background-color:#a0b78b'];
                    }
                }
            },
            'format' => 'html'
        ]
    ]
]);