<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//include_once '../web/connection.php';
class User {

    private $id;
    private $username;
    private $hashedPassword;
    private $email;

    function __construct() {
        $this->id = -1;
        $this->username = '';
        $this->hashedPassword = '';
        $this->email = '';
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setHashedPassword($newPassword) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->hashedPassword = $newHashedPassword;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->hashedPassword;
    }

    function getEmail() {
        return $this->email;
    }

    function saveToDb(mysqli $connection) {
        if ($this->id == -1) {
            $sql = "INSERT INTO Users (username, email, hashed_password) VALUES('$this->username', '$this->email', '$this->hashedPassword')";

            
            if ($res = $connection->query($sql)) {
                $this->id = $connection->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE Users SET username = '$this->username', email = '$this->email',hashed_password = '$this->hashedPassword' WHERE id= $this->id";
        }
        if ($connection->query($sql)) {
            
            return true;
            
        }
        echo 'modyfikacja nie powiodła się' . $connection->error;
        return false;
    }

    static function loadUserById(mysqli $connection, $id) {
        $sql = "SELECT id, username, email, hashed_password FROM Users WHERE id=$id";
        $res = $connection->query($sql);
        if ($res == true && $res->num_rows == 1) {
            $row = $res->fetch_assoc();

            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->email = $row['email'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            // bezpieczniej ustawiać wszystko co się da seterami
            return $loadedUser;
        }
        return null;
    }
    
    static function loadUserByEmail(mysqli $connection, $email) {
        $sql = "SELECT id, username, email, hashed_password FROM Users WHERE email='$email'";
        $res = $connection->query($sql);
        if ($res == true && $res->num_rows == 1) {
            $row = $res->fetch_assoc();

            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->email = $row['email'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            // bezpieczniej ustawiać wszystko co się da seterami
            return $loadedUser;
        } else {
        echo 'Użytkownik o takim mailu nie istnieje';    
        }
        return null;
    }

    static function loadAllUsers(mysqli $connection) {
        $sql = "SELECT * FROM Users";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows > 0) {
            foreach ($result as $row) {

                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->email = $row['email'];
                $loadedUser->hashedPassword = $row['hashed_password'];
                $ret[] = $loadedUser;
            }
        }
        return $ret;
    }

    public function delete(mysqli $connection) {
        if ($this->id != -1) {
            $sql = "DELETE FROM Users WHERE id=$this->id";
            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = -1;
                echo 'rekord usunięty z bazy';
                return true;
            }
            echo 'nie dało usunąć się rekordu';
            return false;
        }
        
        return true;
    }

}





//$a = User::loadUserById($connection, 59);
//var_dump($a);
//$a->delete($connection);
//$a = new User();
//$a->setEmail('janek@wp.pl');
//$a->setHashedPassword('kot');
//$a->setUsername('janek');
//
//$a->saveToDb($connection);


//$a = User::loadUserByEmail($connection, 'janek@wp.pl');
//var_dump($a);