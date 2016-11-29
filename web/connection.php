<?php


$host = 'localhost';
$user = 'root';
$password = 'coderslab';
$database = 'twitter';

$connection = new mysqli($host, $user, $password, $database);
$connection->set_charset("utf8");
if($connection->connect_error){
    die('Połączenie nieudane. Błąd ' . $connection->error);
} 