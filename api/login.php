<?php

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}








$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json,true);



if (!empty($data["login"])) {
    $username = $data["username"];
    $password = $data["password"];
    require_once dirname(__FILE__) . "/../core/data.php";



    $db = Data::init();
    $isLoggedIn = $db->login($username, $password);
    if (!$isLoggedIn) {
        echo "error";
    } else {
        echo $isLoggedIn;
    }
}
