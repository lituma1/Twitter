<?php

class Comment {

    private $id;
    private $user_id;
    private $tweet_id;
    private $creation_date;
    private $text;

    function __construct() {
        $this->id = -1;
        $this->user_id = '';
        $this->tweet_id = '';
        $this->creation_date = '';
        $this->text = '';
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    function setTweet_id($tweet_id) {
        $this->tweet_id = $tweet_id;
    }

    function setCreation_date($creation_date) {
        $this->creation_date = $creation_date;
    }

    function setText($text) {
        $this->text = $text;
    }

    function getId() {
        return $this->id;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getTweet_id() {
        return $this->tweet_id;
    }

    function getCreation_date() {
        return $this->creation_date;
    }

    function getText() {
        return $this->text;
    }

    function saveToDb(mysqli $connection) {
        if ($this->id == -1) {
            $sql = "INSERT INTO Comment (user_id, tweet_id, comment_text, creation_date) VALUES($this->user_id, $this->tweet_id, '$this->text', '$this->creation_date')";
            
            if (!empty($this->text)) {
                $result = $connection->query($sql);
                if ($result) {
                    $this->id = $connection->insert_id;
                    
                    return true;
                } else {
                    echo 'błąd zapisu do bazy' . $connection->error;
                }
            } else {
            echo 'nie dodajemy pustych komentarzy do bazy';    
            }
        }
        return false;
    }
    static function loadCommentById(mysqli $connection, $id) {

        $sql = "SELECT * FROM Comment WHERE id = $id ORDER BY creation_date DESC";
        $result = $connection->query($sql);
        if ($result) {
            if ($result->num_rows != 0) {
                foreach ($result as $row) {
                    $loadedComment = new Comment();
                    $loadedComment->id = $row['id'];
                    $loadedComment->setUser_id($row['user_id']);
                    $loadedComment->setTweet_id($row['tweet_id']);
                    $loadedComment->setText($row['comment_text']);
                    $loadedComment->setCreation_date($row['creation_date']);
                }
                return $loadedComment;
            } 
        } else {
            echo 'błędne zapytanie do bazy' . $connection->error;
        }
    }
     static function loadAllCommentsByPostId(mysqli $connection, $tweetId) {
        $sql = "SELECT id, user_id, tweet_id, comment_text, creation_date FROM Comment WHERE tweet_id= $tweetId ORDER BY creation_date DESC";
        $result = $connection->query($sql);
        $ret = [];
        if($result){
            if($result->num_rows !=0){
                foreach ($result as $row){
                $loadedComment = new Comment();
                    $loadedComment->id = $row['id'];
                    $loadedComment->setUser_id($row['user_id']);
                    $loadedComment->setTweet_id($row['tweet_id']);
                    $loadedComment->setText($row['comment_text']);
                    $loadedComment->setCreation_date($row['creation_date']);
                    $ret[] = $loadedComment;
                }
                return $ret;
            } 
        } else {
        echo 'błędne zapytanie do bazy '.$connection->error;    
        }
    }
    

}

