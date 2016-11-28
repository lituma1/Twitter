<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include_once 'web/connection.php';
include_once 'src/User.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['login']) && !empty($_POST['pass'])) {
        $mail = $_POST['login'];
        $password = $_POST['pass'];
        $user = User::loadUserByEmail($connection, $mail);
        if ($user) {
            $goodPass = password_verify($password, $user->getPassword());

            if ($goodPass) {
                
                $_SESSION['user'] = $user->getId();
                
                header("Location: web/index.php");
                exit;
            } else {
                echo 'Nieprawidłowe hasło';
            }
        
        }
    } else {
        echo 'proszę uzupełnić potrzebne dane';
    }
}
?>
<html lang="pl-PL">
    <head>
        <meta charset="utf-8">
        <title>Strona logowania</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h1>Witaj w serwisie Twitter</h1>
        <h2>Wpisz login i hasło lub przejdź do rejestracji nowego użytkownika</h2>
        <form action="#" method="POST">
            <label>Login:
                <input type="text" name="login" placeholder="Podaj swój mail">
            </label>
            <label>Hasło:
                <input type="password" name="pass" placeholder="Podaj hasło">
            </label>
            <input type="submit" value="Zaloguj">
        </form>
        <br>
        <a id="register" href="web/registration.php">Przejdź do rejestracji nowego użytkownika</a>
    </body>
</html>


