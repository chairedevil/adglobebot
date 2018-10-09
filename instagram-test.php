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

    $img['username'] = $feed->getUserName();
    $img['thumSrc'] = $feed->getMedias()[0]->getThumbnailSrc();
    $img['imgSrc'] = $feed->getMedias()[0]->getDisplaySrc();
    $img['caption'] = $feed->getMedias()[0]->getCaption();

} catch (Exception $exception) {
    print_r($exception->getMessage());
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    print_r($exception->getMessage());
}