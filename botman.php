<?php

require_once('vendor/autoload.php');
require_once('lib/replyMsg.class.php');

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

$config = [

];

// Load the driver(s) you want to use
DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

// Create an instance
$botman = BotManFactory::create($config);

$botman->hears('#{word}', function ($bot, $word) {

    $rm = new replyMsg();
    $replyResult = $rm->translate($word);

    $bot->reply($replyResult, [
        'type' => 'translate',
    ]);

});

$botman->hears('i@{userId}', function ($bot, $userId) {

    $rm = new replyMsg();

    $instaData = $rm->getLastInsta($userId);
    
        $bot->reply('inst', [
            'type' => 'instagram',
            'imgSrc' => $instaData['imgSrc'],
            'caption' => $instaData['caption']
        ]);
    
});

$botman->hears('t@{userId}', function ($bot, $userId) {

    $rm = new replyMsg();

    $tweetData = $rm->getLastTweet($userId);
    
    if(!$tweetData['error']){

        $bot->reply('tweet', [
            'type' => 'twitter',
            'screen_name' => $tweetData['screen_name'],
            'name' => $tweetData['name'],
            'text' => $tweetData['text'],
            'created_at' => $tweetData['created_at'],
            'media' => $tweetData['media']
        ]);

    }

});

$botman->hears('皆に：{text}', function ($bot, $text) {

    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('rY8bFWWrNfgT7geI9PKV3LDb/stfZGW/NakTYGA4m1oaY0W1xvhUlvuSxtEUOWoGK5fAtQFE0eE14KwVBojZKab9gqsurO81WYb7t73zvN1UaAFjVmih0fLi8Nj/5J3ijFihgrg6Lh5vtvmz/RAaFQdB04t89/1O/w1cDnyilFU=');
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '2bc86a87dc5a71bf884791a3b52e67b8']);
    
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
    $response = $bot->pushMessage('U38ff315ae4113e8334945ab5a7349ef9', $textMessageBuilder);
    
    //echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

});

/*
$botman->hears('hello', function (BotMan $bot) {
    $bot->reply('Hello yourself.');
});
*/

$botman->fallback(function($bot) {
    $bot->reply('分からない。。。', [
        'type' => 'error'
    ]);
});

// Start listening
$botman->listen();