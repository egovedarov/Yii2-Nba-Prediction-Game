<?php

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
            'class' => 'kartik\grid\SerialColumn',
            'contentOptions' => ['class' => 'kartik-sheet-style'],
            'width' => '36px',
            'header' => 'Rank',
            'headerOptions' => ['class' => 'kartik-sheet-style'],
        ],
        'username',
        'score'
    ]
]);