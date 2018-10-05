<?php

require_once ('vendor/autoload.php');
use GuzzleHttp\Client;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://api.line.me/v2/bot/message/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);

$response = $client->request('POST', 'push');