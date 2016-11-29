<?php

include_once 'connection.php';
include_once '../src/User.php';
session_start();
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
    $user = User::loadUserById($connection, $userId);
    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (!empty($_POST['old']) && !empty($_POST['new'])) {
        $oldPass = $_POST['old'];
        $newPass = $_POST['new'];
        $goodPass = password_verify($oldPass, $user->getPassword());
        if($goodPass){
            $user->setHashedPassword($newPass);
            $user->saveToDb($connection);
            echo 'zmiana hasła powiodła się';
        } else {
        echo 'wpisałeś niepoprawne hasło';    
        }
    } elseif (!empty($_POST['delete'])) {
        $user->delete($connection);
        unset($_SESSION['user']);
        header("Location: ../index.php");
    } else {
        echo 'metodą post przesłano za mało danych';
    }
}
?>

<html lang="pl-PL">
    <head>
        <meta charset="utf-8">
        <title>Strona główna</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <a class="home" href="index.php">Powrót na stronę główną</a>
        <h2>Tu możesz zmienić swoje hasło</h2>
        <form action="#" method="POST">
            <label>Podaj stare hasło:
                <input type="password" name="old">
            </label>
            <label>Podaj nowe hasło:
                <input type="password" name="new">
            </label>
            <input type="submit" value="Potwierdź zmianę hasła">
            <h2>Jeśli chcesz usunąć konto:</h2>
            <button type="submit" name="delete" value="usun">Usuń konto</button>
        </form>



    </body>
</html>