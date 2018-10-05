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

$botman->hears('@{userId}', function ($bot, $userId) {

    $rm = new replyMsg();

    $instaData = $rm->getLastInsta($userId);
    
        $bot->reply('inst', [
            'type' => 'instagram',
            'imgSrc' => $instaData['imgSrc'],
            'caption' => $instaData['caption']
        ]);
    
});

$botman->hears('@{userId}', function ($bot, $userId) {

    $rm = new replyMsg();

    $tweetData = $rm->getLastTweet($userId);
    
    

});

$botman->hears('hello', function (BotMan $bot) {
    $bot->reply('Hello yourself.');
});

$botman->fallback(function($bot) {
    $bot->reply('分からない。。。', [
        'type' => 'error'
    ]);
});

// Start listening
$botman->listen();