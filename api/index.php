<?php

require_once(__DIR__ . "../core/auth.php");


// data exists
$type = $_POST["type"];
if (empty($type)) exit;


if ($type == "addAcount") {
} elseif ($type == "addTweet") {
} elseif ($type == "deleteTweet") {
} else if ($type == "updateTweet") {
} else exit;
