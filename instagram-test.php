<?php
require_once ('vendor/autoload.php');

$cache = new Instagram\Storage\CacheManager('instragram_cache');

$api = new Instagram\Api($cache);
$api->setUserName('chairedevil');

try {
    $feed = $api->getFeed();
    $img = array();

    //echo "<pre>";
    //print_r($feed);
    //echo "</pre>";

    $img['userName'] = $feed->getUserName();
    $img['fullName'] = $feed->getFullName();
    $img['thumSrc'] = $feed->getMedias()[0]->getThumbnailSrc();
    $img['imgSrc'] = $feed->getMedias()[0]->getDisplaySrc();
    $img['caption'] = $feed->getMedias()[0]->getCaption();
    $img['date'] = $feed->getMedias()[0]->getDate();

    echo "<pre>";
    print_r($img);
    echo "</pre>";

} catch (Exception $exception) {
    //print_r($exception->getMessage());
    echo "c1";
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    //print_r($exception->getMessage());
    echo "c2";
}