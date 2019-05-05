<?php

use app\helpers\Html;
use app\models\activeRecord\NbaTeam;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

$this->title = \Yii::t('app', 'Bets history');

echo GridView::widget([
    'dataProvider' => $dataProvider,

    'rowOptions' => function ($model) {
        return ['style' => 'background-color: #b0b8c4'];
    },
    'columns' => [
        [
            'attribute' => 'v_abrv',
            'label' => 'Visitor',
            'hAlign' => 'center',
            'value' => function ($model, $key, $index, $column) {
                $nbaTeam = NbaTeam::findOne(['abbreviation' => $model->game->v_abrv]);

                $result = Html::img('@web/img/' . $nbaTeam->team_name . '.png', ['height' => 200])
                    . '<br><h3><b>'
                    . $nbaTeam->team_name
                    . '</b></h3><br>';

                if ($model->prediction === 1) {
                    $result .= Html::label('Your prediction.');
                }

                return $result;
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model->prediction === 1) {
                    if ($model->game->winner === 1) {
                        return ['style' => 'background-color:#a0b78b'];
                    } else {
                        return ['style' => 'background-color:#f7503d'];
                    }
                }
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'dt',
            'label' => 'Date',
            'hAlign' => 'center',
            'value' => function ($model, $key, $index, $column) {
                $date = new \DateTime($model->game->dt);
                $interval = new DateInterval('PT5H');
                $date->add($interval);
                $game = $model->game;

                return '<h3><b>'
                    . $date->format("d-m-Y")
                    . "<br>"
                    . $date->format('H:i')
                    . '</b></h3>'
                    . '<h2><b>'
                    . $game->v_team_score . ':' . $game->h_team_score
                    . '</b></h2>';
            },
            'format' => 'html',
        ],
        [
            'attribute' => 'h_abrv',
            'label' => 'Home',
            'hAlign' => 'center',
            'value' => function ($model, $key, $index, $column) {
                $nbaTeam = NbaTeam::findOne(['abbreviation' => $model->game->h_abrv]);

                $result = Html::img('@web/img/' . $nbaTeam->team_name . '.png', ['height' => 200])
                    . '<br><h3><b>'
                    . $nbaTeam->team_name
                    . '</b></h3><br>';

                if ($model->prediction === 2) {
                    $result .= Html::label('Your prediction.');
                }

                return $result;
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model->prediction === 2) {
                    if ($model->game->winner === 2) {
                        return ['style' => 'background-color:#a0b78b'];
                    } else {
                        return ['style' => 'background-color:#f7503d'];
                    }
                }
            },
            'format' => 'html'
        ]
    ]
]);