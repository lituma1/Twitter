<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'connection.php';
include_once '../src/Message.php';
include_once '../src/User.php';
$userId = 26;
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['userId'])) {
        $_userId = $_GET['userId'];
    }
}
$user = User::loadUserById($connection, $userId);
$userName = $user->getUsername();
$messages = Message::loadAllMessagesByUserId($connection, $userId);
//var_dump($messages);
$messagesSent = [];
$messagesRecived = [];
foreach ($messages as $message) {
    if ($message->getRecipient_id() == $userId) {
        $messagesRecived[] = $message;
    } else {
        $messagesSent[] = $message;
    }
}
//var_dump($messagesRecived);
//var_dump($messagesSent);
?>
<html lang="pl-PL">
    <head>
        <meta charset="utf-8">
        <title>Wiadomości</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Wiadomości użytkownika <?php echo $userName ?><h1>
        <h2>Wiadomości otrzymane</h2>
        <h3>Czcionką pogrubioną zaznaczono wiadomości, których jeszcze nie przeczytałeś</h3>
        <table>


            <?php
            echo '<tr>';
            echo '<th>Nadawca</th>';
            echo '<th>Tekst</th>';
            echo '<th>Data</th>';
            foreach ($messagesRecived as $message) {
                $userId = $message->getSender_id();
                $text = substr($message->getText(), 0, 30);
                $user = User::loadUserById($connection, $userId);
                $name = $user->getUsername();
                echo '<tr>';

                echo "<td><a href='usersite.php?userId=$userId'>$name</a></td>";
                if($message->getStatus()==0){
                 echo "<td><a href='message.php?messageId={$message->getId()}'><strong>$text</strong></a></td>";   
                } else {
                  echo  "<td><a href='message.php?messageId={$message->getId()}'>$text</a></td>";
                }
                
                echo '<td>' . $message->getCreation_date() . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
        <h2>Wiadomości wysłane</h2>
        <table>


            <?php
            echo '<tr>';
            echo '<th>Odbiorca</th>';
            echo '<th>Tekst</th>';
            echo '<th>Data</th>';
            foreach ($messagesSent as $message) {
                $userId = $message->getRecipient_id();
                $text = substr($message->getText(), 0, 30);
                var_dump($text);
                $user = User::loadUserById($connection, $userId);
                $name = $user->getUsername();
                echo '<tr>';
                echo "<td><a href='usersite.php?userId=$userId'>$name</a></td>";
                echo  "<td><a href='message.php?messageId={$message->getId()}'>$text</a></td>";
                echo '<td>' . $message->getCreation_date() . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </body>
</html>
