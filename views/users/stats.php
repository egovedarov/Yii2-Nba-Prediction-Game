<?php

use app\models\activeRecord\NbaTeam;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\web\View;

/**
 * @var View $view ,
 * @var ArrayDataProvider $dataProvider
 */

echo Html::label(\Yii::t('app', 'Prediction history statistics'), null, ['style' => 'font-size: 30px']);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'rowOptions' => function ($model) {
        return ['style' => 'background-color: #b0b8c4'];
    },
    // TODO remove item count from header
    'bordered' => true,
    'columns' => [
        [
            'attribute' => 'abbreviation',
            'value' => function ($model, $key, $index, $column) {
                $nbaTeam = NbaTeam::findOne(['abbreviation' => $model['abbreviation']]);

                return '<h3>' . Html::img('@web/img/' . $nbaTeam->team_name . '.png', ['height' => 100, 'style' => 'margin-right: 20px'])
                    . '<b>'
                    . $nbaTeam->team_name
                    . '</b></h3>';
            },
            'format' => 'html',
            'header' => '<h3><b>' . \Yii::t('app', 'Team') . '</b></h3>'
        ],
        [
            'attribute' => 'correct',
            'value' => function ($model) {
                return '<h3>' . $model['correct'] . '/' . $model['all'] . '</h3>';
            },
            'format' => 'html',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'header' => '<h3><b>' . \Yii::t('app', 'Correct/All') . '</b></h3>'
        ],
        [
            'attribute' => 'percentage',
            'value' => function ($model) {
                return '<h3>' . ($model['percentage'] * 100) . '%' . '</h3>';
            },
            'format' => 'html',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'header' => '<h3><b>' . \Yii::t('app', 'Percentage') . '</b></h3>'
        ],
    ],
]);