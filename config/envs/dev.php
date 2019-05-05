<?php

use yii\db\Connection;

return [
    'components' => [
        'db' => [
            'class' => Connection::class,
            'charset' => 'utf8',
            'dsn' => 'mysql:host=localhost;dbname=nba;',
            'password' => 'secret',
            'username' => 'root',
        ]
    ]
];