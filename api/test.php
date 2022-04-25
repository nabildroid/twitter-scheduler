<?php



require_once dirname(__FILE__) . "/../core/twitter.php";


$data = Data::init();

echo $data->login("admin","admin");