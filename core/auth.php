<?php

$auth =  $_SERVER['HTTP_AUTH'];


if (empty($auth)) exit;


require_once dirname(__FILE__) . "/./data.php";


$data  = Data::init();
if (!$data->checkAuth(intval($auth))) {
    exit();
}


