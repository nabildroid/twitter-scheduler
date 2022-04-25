<?php

require_once dirname(__FILE__) . "/core/data.php";
require_once dirname(__FILE__) . "/core/twitter.php";



$db = Data::init();


$tweets = $db->getTweets();



foreach ($tweets as $tweet) {
    $now = time();
    if ($tweet["updated"] + ($tweet["interval"] * 60) < $now) {
        $account = randArray($tweet["accounts"]);

        $twitter = new Twitter($account);

        $country = randArray($tweet["countries"]);

        $hashtags = $twitter->getHashtags($country);

        $hashtag = "#" . str_replace(" ", "_", randArray($hashtags));


        $twitter->tweet($tweet["content"] . "\n" . $hashtag);
        $db->checkTweet($tweet["id"]);
    }
}



function randArray($arr)
{
    return $arr[rand(0, count($arr) - 1)];
}
