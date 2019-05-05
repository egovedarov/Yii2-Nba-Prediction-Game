<?php

use app\components\SimplicateService;
use app\components\SlackService;
use app\components\UniFiService;
use GuzzleHttp\Client;
use yii\di\Container;

call_user_func(function(Container $container) {
    $container->set(
        SimplicateService::class, function() {
        $config = [
            'base_uri' => 'https://wolfpack.simplicate.nl/api/v2/',
            'headers'  => [
                'Accept'                => '*/*',
                'Accept-Encoding'       => 'gzip, deflate',
                'Authentication-Key'    => 'FWqABHcSwxzK1gjiXKMxgdVq4DeX66HB',
                'Authentication-Secret' => 'SX2ku42RrssjyCsld5Jj8vA2YFQVBnnk',
                'Content-Type'          => 'application/json',
            ]
        ];
        $client = new Client($config);
        $simplicateClient = new \Czim\Simplicate\Services\SimplicateClient($client);
        return new SimplicateService($simplicateClient);
    });

    $container->set(
        UniFiService::class,
        function() {
            $uniFi =  new UniFiService(
                'testuser',
                'Fckgw2815',
                'https://192.168.1.37:8443',
                'default',
                '5.7.23',
                false
            );
            $uniFi->login();

            return $uniFi;
        }
    );

    $container->set(
        SlackService::class,
        function() {
//            $guzzleClient = new Client();
//            $slackClient = new SlackService('xoxp-3438664879-433189041600-453691357254-d1e23d7dd98cb3d6e2cf9585621fe10f', $guzzleClient);
            $slackClient = new SlackService('xoxp-3438664879-433189041600-453691357254-d1e23d7dd98cb3d6e2cf9585621fe10f');
            return $slackClient;
        }
    );
}, \Yii::$container);