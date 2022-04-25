<?php


$auth =  $_SERVER['HTTP_AUTH'];

if (empty($auth)) exit;


require_once(__DIR__ . "../core/data.php");

$data  = new Data();

if (!$data->checkAuth($auth)) {
    exit();
}
