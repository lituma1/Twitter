<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tweet
 *
 * @author pp
 */
include_once '../web/connection.php';
class Tweet {
    //put your code here
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
        if(strlen($text <= 140)){
            $this->text = $text;
        } else {
        echo 'Twój tweet jest za długi maksymalna długość znaków to 140';    
        }
        
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

    static function loadTweetById(mysqli $connection, $id){
       
    }
    static function loadAllTweetsByUserId(mysqli $connection, $userId){
        
    }
    function saveToDb(mysqli $connection){
        if($this->id == -1){
            $sql = "INSERT INTO Tweet (user_id, tweet_text, creation_date) VALUES ('$this->userId', '$this->text', '$this->creationDate')";
            $connection->set_charset("utf8");
                    
            $result = $connection->query($sql);
            if($result){
                $this->id = $connection->insert_id;
                return true;
            } else {
            echo 'nie dodano tweeta do bazy'.$connection->error;    
            }
        }
        return false;
    } 
}
//$db = new mysqli('localhost', 'root', 'coderslab', 'twitter');
//if ($db->connect_error) {
//    die("Połączenie nieudane. Blad: " . $db->connect_error);
//} else {
//    echo 'Połącznie udane' . '<br>';
//}
$tweet = new Tweet();
$tweet->setText('Dobranoc na dziś wystarczy ciekawe kiedy przekroczę 140 znaków');
$tweet->setUserId(1);
$tweet->setCreationDate(date('Y-m-d H:i:s'));
var_dump($tweet);
$tweet->saveToDb($connection);

