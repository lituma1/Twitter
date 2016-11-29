<?php

class Message {
   
    private $id;
    private $sender_id;
    private $recipient_id;
    private $text;
    private $status;
    private $creation_date;
    
    function __construct() {
        $this->id = -1;
        $this->sender_id = '';
        $this->recipient_id = '';
        $this->text = '';
        $this->status = '';
        $this->creation_date = ''; 
    }
    function setSender_id($sender_id) {
        $this->sender_id = $sender_id;
    }

    function setRecipient_id($recipient_id) {
        $this->recipient_id = $recipient_id;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreation_date($creation_date) {
        $this->creation_date = $creation_date;
    }
    function getId() {
        return $this->id;
    }

    function getSender_id() {
        return $this->sender_id;
    }

    function getRecipient_id() {
        return $this->recipient_id;
    }

    function getText() {
        return $this->text;
    }

    function getStatus() {
        return $this->status;
    }

    function getCreation_date() {
        return $this->creation_date;
    }

    function saveToDb(mysqli $connection){
        if($this->id == -1){
            $sql = "INSERT INTO Message (sender_id, recipient_id, message_text, status, creation_date) VALUES ($this->sender_id, $this->recipient_id, '$this->text', $this->status, '$this->creation_date')";
           
            $result = $connection->query($sql);
            if($result){
                $this->id = $connection->insert_id;
                return true;
            }
            echo 'nie udało się wysłać wiadomości'.$connection->error;
        } else {
             $sql = "UPDATE Message SET status = 1 WHERE id= $this->id";
        }
        if ($connection->query($sql)) {
            echo 'zapis w bazie zmodyfikowany';
            return true;
            
        }
        echo 'modyfikacja nie powiodła się' . $connection->error;
        return false;
    }
    static function loadAllMessagesByUserId(mysqli $connection, $userId){
        $sql = "SELECT * FROM Message WHERE sender_id= $userId OR recipient_id = $userId  ORDER BY creation_date DESC";
        //echo $sql;
        $result = $connection->query($sql);
        $ret = [];
        if($result){
            if($result->num_rows !=0){
                foreach ($result as $row){
                $loadedMessage = new Message();
                    $loadedMessage->id = $row['id'];
                    $loadedMessage->setSender_id($row['sender_id']);
                    $loadedMessage->setRecipient_id($row['recipient_id']);
                    $loadedMessage->setStatus($row['status']);
                    $loadedMessage->setText($row['message_text']);
                    $loadedMessage->setCreation_date($row['creation_date']);
                    $ret[] = $loadedMessage;
                }
                return $ret;
            } else {
            echo 'użytkownik o podanym id nie wysłał jeszcze tweetów';    
            }
        } else {
        echo 'błędne zapytanie do bazy '.$connection->error;    
        }
    }
    static function loadMessageById(mysqli $connection, $id){
        $sql = "SELECT * FROM Message WHERE id = $id";
        $result = $connection->query($sql);
        if ($result) {
            if ($result->num_rows != 0) {
                foreach ($result as $row) {
                    $loadedMessage = new Message();
                    $loadedMessage->id = $row['id'];
                    $loadedMessage->setSender_id($row['sender_id']);
                    $loadedMessage->setRecipient_id($row['recipient_id']);
                    $loadedMessage->setText($row['message_text']);
                    $loadedMessage->setStatus($row['status']);
                    $loadedMessage->setCreation_date($row['creation_date']);
                }
                return $loadedMessage;
            } else {
                echo 'wiadomość o podanym id nie istnieje';
            }
        } else {
            echo 'błędne zapytanie do bazy' . $connection->error;
        }
    }
    
}

