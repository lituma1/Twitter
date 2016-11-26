<?php
include_once 'connection.php';
include_once '../src/Tweet.php';
include_once '../src/User.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if($_SERVER['REQUEST_METHOD']==='GET'){
    //var_dump($_GET);
    $tweetId = $_GET['tweetId'];
   if(isset($tweetId) && is_numeric($tweetId)){
       $tweet = Tweet::loadTweetById($connection, $tweetId);
       //var_dump($tweet);
       $userId = $tweet->getUserId();
       $user = User::loadUserById($connection, $userId);
       $userName = $user->getUsername();
       $text = $tweet->getText();
       $data = $tweet->getCreationDate();
   }
}
?>
<html lang="pl-PL">
    <head>
        <meta charset="utf-8">
        <title>Tweet</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h2>Poniżej informacje o tweecie</h2>
        <?php
        echo '<h3>Autor tweetu: <h3>';
        echo "<p>$userName</p>";
        echo '<h3>Tekst:<h3>';
        echo "<p>$text</p>";
        echo '<h3>Data wysłania:<h3>';
         echo "<p>$data</p>";
        
        ?>
    </body>
</html>
