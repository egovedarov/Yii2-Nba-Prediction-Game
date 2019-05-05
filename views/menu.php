<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\ArrayHelper;
use yii\web\View;

/**
 * @var View $this
 */

NavBar::begin([
    'brandLabel' => \Yii::$app->name,
    'brandUrl' => \Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

$menuItems = [
    ['label' => \Yii::t('app', 'Home'), 'url' => \Yii::$app->homeUrl]
];

if (Yii::$app->user->isGuest) {
    $menuItems = ArrayHelper::merge($menuItems,
        [
            ['label' => 'Login', 'url' => ['/session/login']],
            ['label' => 'Register', 'url' => ['/users/register']]
        ]
    );
} else {
    $menuItems = ArrayHelper::merge($menuItems, [
        ['label' => 'Today\'s Games', 'url' => ['/games/today']],
        ['label' => 'Bets History', 'url' => ['/bets/history']],
        ['label' => \Yii::t('app', 'User Ranking'), 'url' => ['/bets/ranking']],
        ['label' => 'Score: ' . \Yii::$app->user->identity->score]
    ]);
}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' =>
        $menuItems
]);
NavBar::end();