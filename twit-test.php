<?php
require_once ('vendor/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

define("CONSUMER_KEY", "CG7i3j2bl0eYIv99vjMSvbY1I");
define("CONSUMER_SECRET", "RULVj5gepeAgg39xgRpR53F1aNILj2qOJhaAdGA8alnNHVBHhG");
$access_token = "62762346-tARVF3nuh0Uuul6834tw4gmr8prKwREBOoSiv73mH";
$access_token_secret = "EoTp7Evg15OCW04zMYshyK8h4FifhB3SXfaYNMfRKlZWy";

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
$content = $connection->get("account/verify_credentials");
echo '<pre>';
print_r($content);
echo '</pre>';

//$statuses = $connection->get("statuses/home_timeline", ["count" => 1, "exclude_replies" => true]);
$statuses = $connection->get("statuses/user_timeline", ["screen_name" => "dragalialost", "count" => 1]);

echo '<pre>';
print_r($statuses[0]->user->screen_name);
echo '</pre>';

echo '<pre>';
print_r($statuses);
echo '</pre>';