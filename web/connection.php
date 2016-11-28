<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$host = 'localhost';
$user = 'root';
$password = 'coderslab';
$database = 'twitter';

$connection = new mysqli($host, $user, $password, $database);
$connection->set_charset("utf8");
if($connection->connect_error){
    die('Połączenie nieudane. Błąd ' . $connection->error);
} 