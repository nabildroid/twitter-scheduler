<?php



class Data
{


    private static $_instance;

    static function init()
    {
        if (Data::$_instance) return Data::$_instance;
        Data::$_instance = new Data();
        return Data::$_instance;
    }

    private function __construct()
    {

        $path = dirname(__FILE__) . "/../data.json";
        $file = file_get_contents($path);

        $this->data = json_decode($file, true);
    }


    function checkAuth($auth)
    {

        return $this->data["login"]["auth"] == $auth;
    }

    function login($name, $password)
    {
        $login =  $this->data["login"];

        if ($name == $login["username"] && $password == $login["password"]) {
            $rand =  random_int(1, 100000000000);
            $this->data["login"]["auth"] = $rand;

            $this->save();

            return $rand;
        }

        return false;
    }

    function addAccount($id, $name, $key, $secret)
    {
        $this->deleteAccount($id);
        $account = [
            "id" => $id,
            "key" => $key,
            "secret" => $secret,
            "name" => $name,
        ];


        array_push($this->data["accounts"], $account);

        $this->save();
    }


    function getAccounts()
    {
        $accounts = [];

        foreach ($this->data["accounts"] as $account) {
            $accounts[] = [
                'id' => $account['id'],
                'name' => $account['name'],
            ];
        }

        return $accounts;
    }
    function getAccount($id)
    {
        foreach ($this->data["accounts"] as $_ => $value) {
            if (intval($value["id"]) == $id) return $value;
        }
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

    function deleteAccount($id)
    {
        $accounts = [];
        foreach ($this->data["accounts"] as $key => $value) {
            if ($value["id"] != $id) {
                $accounts[] = $value;
            }
        }
        $this->data["accounts"] = $accounts;

        $this->save();
    }

    function getTweets()
    {
        return $this->data["tweets"];
    }

    function addTweet($content, $accounts, $countries, $interval)
    {
        $tweet = [
            "id" => random_int(10000, 99999999999),
            "content" => $content,
            "accounts" => $accounts,
            "interval" => $interval,
            "countries" => $countries,
            "updated" => time(),
        ];

        array_push($this->data["tweets"], $tweet);

        $this->save();

        return $tweet;
    }


    function checkTweet($id)
    {
        foreach ($this->data["tweets"] as $_ => $value) {
            if ($value["id"] == $id) {
                $value["updated"] = time();

                $this->deleteTweet($value["id"]);

                array_push($this->data["tweets"], $value);

                $this->save();

                return $value;
            }
        }
    }

    function updateTweet($id, $content, $accounts, $countries, $interval)
    {
        foreach ($this->data["tweets"] as $_ => $value) {
            if ($value["id"] == $id) {
                if ($content) {
                    $value["content"] = $content;
                }
                if ($accounts) {
                    $value["accounts"] = $accounts;
                }
                if ($countries) {
                    $value["countries"] = $countries;
                }
                if ($interval) {
                    $value["interval"] = $interval;
                }

                $this->deleteTweet($value["id"]);



                array_push($this->data["tweets"], $value);


                $this->save();

                return $value;
            }
        }
    }

    private function save()
    {

        $path = dirname(__FILE__) . "/../data.json";

        $data = json_encode($this->data);
        file_put_contents($path, $data);
    }
}
