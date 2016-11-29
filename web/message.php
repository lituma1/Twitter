<?php


include_once 'connection.php';
include_once '../src/Message.php';
include_once '../src/User.php';
session_start();
$userId = $_SESSION['user'];
if($_SERVER['REQUEST_METHOD']==='GET'){
    
    if(!empty($_GET['messageId'])){
        $id = $_GET['messageId'];
        
        $message = Message::loadMessageById($connection, $id);
        
        $text = $message->getText();
        $senderId = $message->getSender_id();
        
        $sender = User::loadUserById($connection, $senderId);
        $senderName = $sender->getUsername();
        $date = $message->getCreation_date();
        if($senderId != $userId){
        $message->saveToDb($connection); 
        }
        
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
        <a class="home"  href="messages.php">Powrót do wiadomości</a>
        <h2>Poniżej informacje i pełen tekst klikniętej wiadomości</h2>
        <table>
            <tr>
                <th>Nadawca</th>
                <th>Tekst</th>
                <th>Data</th>
            </tr>
            <tr>
            <?php
            echo "<td><a href='usersite.php?userId=$senderId'>$senderName</a></td>";
            echo "<td>$text</td>";
            echo "<td>$date</td>";
            ?>
            </tr>
        </table>
     
    </body>
</html>