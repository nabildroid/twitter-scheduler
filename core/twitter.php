<?php


require_once dirname(__FILE__) . "/../vendor/autoload.php";
require_once dirname(__FILE__) . "/../config.php";
require_once dirname(__FILE__) . "/data.php";


use Abraham\TwitterOAuth\TwitterOAuth;


class Twitter
{

    private $data;
    private $client;

    function __construct($accountId)
    {
        $this->data = new Data();
        $account = $this->data->getAccount($accountId);

        $this->client = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $account['key'], $account['secret']);
    }


    function getHashtags($countryId)
    {
        $hashtags = [];
        $data = $this->get("trends/place", ["id" => $countryId]);
        foreach ($data[0]["trends"] as $item)
            $hashtags[] = str_replace("#","",str_replace("_"," ",$item["name"]));

        return $hashtags;
    }


    function tweet($content)
    {
        $this->post("statuses/update", ["status" => $content]);
    }


    function reply($id, $content)
    {
    }


    private function get($req, $params=[])
    {

        $data = $this->client->get($req, $params);
        return json_decode(json_encode($data), true);
    }

    private function post($req, $params=[])
    {
        $data = $this->client->post($req, $params);
        return json_decode(json_encode($data), true);
    }



    function getCountries()
    {
        $countries = [];
        $data = $this->get("trends/available");
        // var_dump($data);

        foreach ($data as  $item) {
            $countries[] = [
                "country" => $item["country"],
                "name" => $item["name"],
                "id" => $item["woeid"],
            ];
        }

        return $countries;
    }
}
