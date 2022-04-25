<?php

require "../vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


class Twitter
{

    private $secret;

    function __construct($secret)
    {
        $this->secret = $secret;
    }


    function getHashtags()
    {
    }


    function tweet($content)
    {
    }


    function reply($id, $content)
    {
    }
}
