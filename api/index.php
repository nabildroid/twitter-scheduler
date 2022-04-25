<?php
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}


require_once dirname(__FILE__) . "/../core/auth.php";
require_once dirname(__FILE__) . "/../core/twitter.php";

$json = file_get_contents('php://input');


// Converts it into a PHP object
$data = json_decode($json, true);

$type = $data["type"];



// data exists
if (empty($type)) exit;


$db = Data::init();

if ($type == "getTweets") {
    $tweets = $db->getTweets();


    echo json_encode($tweets);
    exit;
} elseif ($type == "addTweet") {
    $tweet = $data["tweet"];

    $newTweet = $db->addTweet($tweet["content"], $tweet["accounts"], $tweet["countries"], $tweet["interval"]);

    echo json_encode($newTweet);
    exit;
} elseif ($type == "deleteTweet") {
    $id = $data["id"];
    $db->deleteTweet($id);

    echo "{}";
    exit;
} else if ($type == "updateTweet") {

    $id = $data["id"];
    $tweet = $data["tweet"];

    $newTweet = $db->updateTweet($id, $tweet["content"], $tweet["accounts"], $tweet["countries"], $tweet["interval"]);

    echo json_encode($newTweet);
    exit;
} else if ($type == "getCountries") {

    $id = $data["id"];


    $twitter = new Twitter($id);

    $countries = $twitter->getCountries();

    echo json_encode($countries);
    exit;
} else if ($type == "getAccounts") {

    $accounts = $db->getAccounts();

    echo json_encode($accounts);
    exit;
} else exit;
