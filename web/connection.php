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

$conn = new mysqli($host, $user, $password, $database);

if($conn->connect_error){
    die('Połączenie nieudane. Błąd ' . $conn->error);
} else {
    echo 'Połączenie udane';    
}