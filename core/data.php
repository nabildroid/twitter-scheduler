<?php

class Data
{
    private $path = "../data.json";

    private $data;

    function __construct()
    {

        $file = file_get_contents($this->path);

        $this->data = json_decode($file, true);
    }


    function checkAuth($auth)
    {
        return $this->data["auth"] == $auth;
    }

    function login($name, $password)
    {
        $login =  $this->data["login"];

        if ($name == $login["username"] && $password == $login["password"]) {
            $rand = random_bytes(250);
            $this->data["login"]["auth"] = $rand;
            $this->save();
            return $rand;
        }

        return false;
    }

    function addAccount($name, $secret)
    {
        array_push($this->data["accounts"], [
            "id" => random_int(10000, 99999999999),
            "key" => $secret,
            "name" => $name,
        ]);

        $this->save();
    }

    function deleteTweet($id)
    {
        $tweets = [];
        foreach ($this->data["tweets"] as $key => $value) {
            if ($value["id"] != $id) {
                $tweets[] = $value;
            }
        }
        $this->data["tweets"] = $tweets;

        $this->save();
    }

    function addTweet($content, $accounts, $interval)
    {
        $tweet = [
            "id" => random_int(10000, 99999999999),
            "content" => $content,
            "accounts" => $accounts,
            "interval" => $interval,
            "updated" => time(),
        ];

        array_push($this->data["tweets"], $tweet);

        $this->save();
    }

    function updateTweet($id, $content, $accounts, $interval)
    {
        foreach ($this->data["tweets"] as $_ => $value) {
            if ($value["id"] == $id) {
                $this->deleteTweet($value["id"]);
                if ($content) {
                    $value["content"] = $content;
                }
                if ($accounts) {
                    $value["accounts"] = $accounts;
                }
                if ($interval) {
                    $value["interval"] = $interval;
                }
                break;

                array_push($this->data["tweets"], $value);

                $this->save();
            }
        }
    }

    private function save()
    {
        $data = json_encode($this->data);
        file_put_contents($this->path, $data);
    }
}
