<?php

use Abraham\TwitterOAuth\TwitterOAuth;

define("CONSUMER_KEY", "CG7i3j2bl0eYIv99vjMSvbY1I");
define("CONSUMER_SECRET", "RULVj5gepeAgg39xgRpR53F1aNILj2qOJhaAdGA8alnNHVBHhG");
$access_token = "62762346-tARVF3nuh0Uuul6834tw4gmr8prKwREBOoSiv73mH";
$access_token_secret = "EoTp7Evg15OCW04zMYshyK8h4FifhB3SXfaYNMfRKlZWy";

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
$content = $connection->get("account/verify_credentials");

$statuses = $connection->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);

echo '<pre>';
print_r($statuses);
echo '</pre>';