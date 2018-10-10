<?php
require_once ('vendor/autoload.php');

$cache = new Instagram\Storage\CacheManager('instragram_cache');

$api = new Instagram\Api($cache);
$api->setUserName('chairedevil');

try {
    $feed = $api->getFeed();
    $img = array();

    echo "<pre>";
    print_r($feed);
    echo "</pre>";

    echo $img['userName'] = $feed->getUserName();
    echo $img['fullName'] = $feed->fullName();
    echo $img['thumSrc'] = $feed->getMedias()[0]->getThumbnailSrc();
    echo $img['imgSrc'] = $feed->getMedias()[0]->getDisplaySrc();
    echo $img['caption'] = $feed->getMedias()[0]->getCaption();
    echo $img['date'] = $feed->getMedias()[0]->getDate();

} catch (Exception $exception) {
    //print_r($exception->getMessage());
    echo "c1";
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    //print_r($exception->getMessage());
    echo "c2";
}