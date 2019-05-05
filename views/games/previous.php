<?php

use app\helpers\Html;
use app\models\activeRecord\NbaTeam;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var int $daysToSubtract
 */

$this->title = \Yii::t('app', 'Previous games');

$date = new \DateTime();
$interval = new \DateInterval(sprintf('P%dD', $daysToSubtract));
$date->sub($interval);

echo Html::a($date->format('Y-m-d'), Url::to(['games/previous', 'daysToSubtract' => ++$daysToSubtract]), ['class' => 'btn btn-primary']);

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
                $nbaTeam = NbaTeam::findOne(['abbreviation' => $model->v_abrv]);

                $result = Html::img('@web/img/' . $nbaTeam->team_name . '.png', ['height' => 200])
                    . '<br><h3><b>'
                    . $nbaTeam->team_name
                    . '</b></h3><br>';

                return $result;
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model->winner === 1) {
                    return ['style' => 'background-color:#a0b78b'];
                } else {
                    return ['style' => 'background-color:#f7503d'];
                }
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'dt',
            'label' => 'Date',
            'hAlign' => 'center',
            'value' => function ($model, $key, $index, $column) {
                $date = new \DateTime($model->dt);
                $interval = new DateInterval('PT5H');
                $date->add($interval);
                $model;

                return '<h3><b>'
                    . $date->format("d-m-Y")
                    . "<br>"
                    . $date->format('H:i')
                    . '</b></h3>'
                    . '<h2><b>'
                    . $model->v_team_score . ':' . $model->h_team_score
                    . '</b></h2>';
            },
            'format' => 'html',
        ],
        [
            'attribute' => 'h_abrv',
            'label' => 'Home',
            'hAlign' => 'center',
            'value' => function ($model, $key, $index, $column) {
                $nbaTeam = NbaTeam::findOne(['abbreviation' => $model->h_abrv]);

                $result = Html::img('@web/img/' . $nbaTeam->team_name . '.png', ['height' => 200])
                    . '<br><h3><b>'
                    . $nbaTeam->team_name
                    . '</b></h3><br>';

                return $result;
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model->winner === 2) {
                    return ['style' => 'background-color:#a0b78b'];
                } else {
                    return ['style' => 'background-color:#f7503d'];
                }
            },
            'format' => 'html'
        ]
    ]
]);