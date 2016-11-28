<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'connection.php';
include_once '../src/User.php';
session_start();
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!empty($_POST['haslo']) && !empty($_POST['mail'])){
        $email = $_POST['mail'];
        $haslo = $_POST['haslo'];
        $nick = $_POST['nick'];
        $sql = "SELECT id, username, email, hashed_password FROM Users WHERE email='$email'";
        $result = $connection->query($sql);
        if($result && $result->num_rows == 0){
            $user = new User();
            $user->setEmail($email);
            $user->setHashedPassword($haslo);
            $user->setUsername($nick);
            $user->saveToDb($connection);
            $user2 = User::loadUserByEmail($connection, $email);
            $userId = $user2->getId();
            $_SESSION['user'] = $userId;
            header("Location: index.php");
                exit;
        } else {
        echo 'podany mail jest już zajęty';    
        }
    }
}
?>

<html lang="pl-PL">
    <head>
        <meta charset="utf-8">
        <title>Rejestracja</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Rejestracja w serwisie Twitter</h1>
        <form action="#" method="POST">
             <label>Podaj swój nick:
                <input type="text" name="nick" placeholder="Podaj swój nick">
            </label>
            <label>Podaj adres email:
                <input type="text" name="mail" placeholder="Podaj swój mail">
            </label>
            <label>Utwórz hasło:
                <input type="password" name="haslo" placeholder="Wprowadź swoje hasło">
            </label>
            <input type="submit" value="Zarejestruj">
        </form>
        
    </body>
</html>