<?php

require_once ('vendor/autoload.php');

/*
use GuzzleHttp\Client;

$client = new Client([
    'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer rY8bFWWrNfgT7geI9PKV3LDb/stfZGW/NakTYGA4m1oaY0W1xvhUlvuSxtEUOWoGK5fAtQFE0eE14KwVBojZKab9gqsurO81WYb7t73zvN1UaAFjVmih0fLi8Nj/5J3ijFihgrg6Lh5vtvmz/RAaFQdB04t89/1O/w1cDnyilFU='
        ]
]);

$response = $client->post('https://api.line.me/v2/bot/message/push', [
    GuzzleHttp\RequestOptions::JSON => [
        'to' => 'U38ff315ae4113e8334945ab5a7349ef9',
        "messages" => [
            "type"=>"text",
            "text"=>"Hello, world1"
        ]
        ]
]);

echo '<pre>' . var_export($response->getStatusCode(), true) . '</pre>';
echo '<pre>' . var_export($response->getBody()->getContents(), true) . '</pre>';
*/

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('rY8bFWWrNfgT7geI9PKV3LDb/stfZGW/NakTYGA4m1oaY0W1xvhUlvuSxtEUOWoGK5fAtQFE0eE14KwVBojZKab9gqsurO81WYb7t73zvN1UaAFjVmih0fLi8Nj/5J3ijFihgrg6Lh5vtvmz/RAaFQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '2bc86a87dc5a71bf884791a3b52e67b8']);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->pushMessage('U38ff315ae4113e8334945ab5a7349ef9', $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();