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
    
    if($tweetData['error']){

        $bot->reply('tweet', [
            'type' => 'twitter',
            'screen_name' => $tweetData['screen_name'],
            'name' => $tweetData['name'],
            'text' => $tweetData['text'],
            'created_at' => $tweetData['created_at'],
            'media' => $tweetData['media']
        ]);

        $tweet['screen_name'] = $statuses[0]->user->screen_name;
        $tweet['name'] = $statuses[0]->user->name;
        $tweet['text'] = $statuses[0]->text;
        $tweet['created_at'] = $statuses[0]->created_at;
        $tweet['media'] = $statuses[0]->entities->media[0]->media_url;

    }

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