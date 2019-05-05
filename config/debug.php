<?php

$result = [
    'bootstrap' =>
        !defined('CONSOLE') || !CONSOLE
            ? ['debug']
            : [],
    'modules' => [
        'debug' => [
            'class' => yii\debug\Module::class,
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.*', '*'],
        ]
    ]
];

return $result;