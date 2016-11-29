<?php

class Tweet {

    private $id;
    private $userId;
    private $text;
    private $creationDate;

    function __construct() {
        $this->id = -1;
        $this->userId = '';
        $this->text = '';
        $this->creationDate = '';
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setText($text) {
        $this->text = $text;
//        if(strlen($text <= 140)){
//            $this->text = $text;
//        } else {
//        echo 'Twój tweet jest za długi maksymalna długość znaków to 140';    
//        }
    }

    function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getText() {
        return $this->text;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    static function loadAllTweets(mysqli $connection) {
        $ret = [];
        $sql = "SELECT * FROM Tweet ORDER BY creation_date DESC";
        $result = $connection->query($sql);
        if ($result && $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->setUserId($row['user_id']);
                $loadedTweet->setText($row['tweet_text']);
                $loadedTweet->setCreationDate($row['creation_date']);
                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }

    static function loadTweetById(mysqli $connection, $id) {

        $sql = "SELECT * FROM Tweet WHERE id = $id";
        $result = $connection->query($sql);
        if ($result) {
            if ($result->num_rows != 0) {
                foreach ($result as $row) {
                    $loadedTweet = new Tweet();
                    $loadedTweet->id = $row['id'];
                    $loadedTweet->setUserId($row['user_id']);
                    $loadedTweet->setText($row['tweet_text']);
                    $loadedTweet->setCreationDate($row['creation_date']);
                }
                return $loadedTweet;
            } else {
                echo 'tweet o podanym id nie istnieje';
            }
        } else {
            echo 'błędne zapytanie do bazy' . $connection->error;
        }
    }

    static function loadAllTweetsByUserId(mysqli $connection, $userId) {
        $sql = "SELECT * FROM Tweet WHERE user_id= $userId ORDER BY creation_date DESC";
        $result = $connection->query($sql);
        $ret = [];
        if($result){
            if($result->num_rows !=0){
                foreach ($result as $row){
                $loadedTweet = new Tweet();
                    $loadedTweet->id = $row['id'];
                    $loadedTweet->setUserId($row['user_id']);
                    $loadedTweet->setText($row['tweet_text']);
                    $loadedTweet->setCreationDate($row['creation_date']);
                    $ret[] = $loadedTweet;
                }
                return $ret;
            } else {
            echo 'użytkownik o podanym id nie wysłał jeszcze tweetów';    
            }
        } else {
        echo 'błędne zapytanie do bazy '.$connection->error;    
        }
    }

    function saveToDb(mysqli $connection) {
        if ($this->id == -1) {
            $sql = "INSERT INTO Tweet (user_id, tweet_text, creation_date) VALUES ('$this->userId', '$this->text', '$this->creationDate')";

            if (!empty($this->text)) {
                $result = $connection->query($sql);
                if ($result) {
                    $this->id = $connection->insert_id;
                    return true;
                } else {
                    echo 'nie dodano tweeta do bazy' . $connection->error;
                }
            } else {
                echo 'nie dodajemy pustych tweetów do bazy';
            }
        }
        return false;
    }

}

//$tweet = new Tweet();
//$tweet->setText('');
//$tweet->setUserId(26);
//$tweet->setCreationDate(date('Y-m-d H:i:s'));
//var_dump($tweet);
//$tweet->saveToDb($connection);
//$array = Tweet::loadAllTweets($connection);
//var_dump($array);
//$tweet = Tweet::loadAllTweets($connection);
//var_dump($tweet);


