<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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

            //echo $sql;
            if ($res = $connection->query($sql)) {
                $this->id = $connection->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE Users SET"
                    . " username = '$this->username,"
                    . " email = $this->email',"
                    . " hashed_password = $this->hashedPassword'"
                    . "WHERE "
                    . "id= $this->id";
        }
        if ($connection->query($sql)) {
            return true;
        }
        return false;
    }

    static function loadUserById(mysqli $connection, $id) {
        $sql = "SELECT id, username, email, hashed_password FROM Users WHERE id=" . $id;
        $res = $connection->query($sql);
        if ($res == true && $res->num_rows == 1) {
            $row = $res->fetch_assoc();

            $loadedUser = new User();
            $loadedUser->username = $row['username'];
            $loadedUser->email = $row['email'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            // bezpieczniej ustawiać wszystko co się da seterami
            return $loadedUser;
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
                return true;
            }
            return false;
        }
        return true;
    }

}

$db = new mysqli('localhost', 'root', 'coderslab', 'test');
if ($db->connect_error) {
    die("Połączenie nieudane. Blad: " . $db->connect_error);
} else {
    echo 'Połącznie udane' . '<br>';
}
//$user = new User();
//$user->setEmail('bolek@wp2.pl');
//$user->setUsername('tomek');
//$user->setHashedPassword('sanki');
////$user->saveToDb($db);
//if($user->saveToDb($db)){
//    echo 'user zapisany';
//} else {
//    echo 'user niezapisany';
//}

//$u = User::loadUserById($db, $id = 1);
//if ($u) {
//    echo 'Użytkownik ' . $u->getUsername() . ' wczytany poprawnie';
//    $u->setHashedPassword('rowerek');
//    //$u->setUsername('piotr');
//    $u->saveToDb($db);
//} else {
//    echo 'Nie udało się wczytać użytkownika o  id=' . $id;
//}
//
//var_dump($u);
//$arr = User::loadAllUsers($db);
//var_dump($arr);
$v = new User();
var_dump($v);
