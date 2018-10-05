<?php
    require_once ('./vendor/autoload.php');
    use \Dejurin\GoogleTranslateForFree;
    use \DetectLanguage\DetectLanguage;
    use Abraham\TwitterOAuth\TwitterOAuth;

    class replyMsg
    {
        public function translate($msg){

            $tr = new GoogleTranslateForFree();

            DetectLanguage::setApiKey("87bd89dad3e829243777382a605b2dc2");
            $languageCode = DetectLanguage::simpleDetect($msg);

            if($languageCode == 'ja'){
                $returnMsg = $tr->translate('ja', 'en', $msg);
            }else{
                $returnMsg = $tr->translate('auto', 'ja', $msg);
            }

            //$returnMsg = $tr->translate('ja', 'en', $msg);

            //if($msg == $returnMsg){
            //    $returnMsg = $tr->translate('en', 'ja', $msg);
            //}

            return $returnMsg;
        }

        public function getLastInsta($userId){

            $cache = new Instagram\Storage\CacheManager('instragram_cache');

            $api = new Instagram\Api($cache);
            $api->setUserName($userId);

            try {
                $feed = $api->getFeed();
                $thumSrc = $feed->getMedias()[0]->getThumbnailSrc();
                $imgSrc = $feed->getMedias()[0]->getDisplaySrc();
                $caption = $feed->getMedias()[0]->getCaption();
                $img = array();
                $img['thumSrc'] = $thumSrc;
                $img['imgSrc'] = $imgSrc;
                $img['caption'] = $caption;

            } catch (Exception $exception) {
                print_r($exception->getMessage());
            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                print_r($exception->getMessage());
            }


            return $img;
        }

        public function getLastTweet($userId){
            define("CONSUMER_KEY", "CG7i3j2bl0eYIv99vjMSvbY1I");
            define("CONSUMER_SECRET", "RULVj5gepeAgg39xgRpR53F1aNILj2qOJhaAdGA8alnNHVBHhG");
            $access_token = "62762346-tARVF3nuh0Uuul6834tw4gmr8prKwREBOoSiv73mH";
            $access_token_secret = "EoTp7Evg15OCW04zMYshyK8h4FifhB3SXfaYNMfRKlZWy";

            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
            $content = $connection->get("account/verify_credentials");

            $statuses = $connection->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);

            return $statuses;
        }
    }

?>