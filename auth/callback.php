<?php

require "../vendor/autoload.php";
require "../config.php";
require "../core/data.php";

use Abraham\TwitterOAuth\TwitterOAuth;

session_start();

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    echo "unvalide data";
    exit();
}

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);

$data = Data::init();



$data->addAccount($access_token["user_id"], $access_token["screen_name"], $access_token["oauth_token"], $access_token["oauth_token_secret"]);



header('Location: ' . "/scheduler");
exit();
