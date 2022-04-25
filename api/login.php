<?php

if (!empty($_POST["login"])) {
    $username = filter_var($_POST["username"]);
    $password = filter_var($_POST["password"]);
    require_once(__DIR__ . "../core/data.php");

    $data = new Data();
    $isLoggedIn = $data->login($username, $password);
    if (!$isLoggedIn) {
        echo "error";
    } else {
        echo $isLoggedIn;
    }
}
