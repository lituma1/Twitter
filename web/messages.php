<?php

include_once 'connection.php';
include_once '../src/Message.php';
include_once '../src/User.php';
session_start();
$userId = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['message'])) {
        $text = $_POST['message'];
    }
}


if (!empty($_GET['recipientId'])) {
    $recipientId = $_GET['recipientId'];
    if ($userId != $recipientId) {
        $message = new Message();
        $message->setCreation_date(date('Y-m-d H:i:s'));
        $message->setRecipient_id($recipientId);
        $message->setSender_id($userId);
        $message->setStatus(0);
        $message->setText($text);
        $message->saveToDb($connection);
    } else {
        echo 'nie można wysłać wiadomości do siebie';
    }
} 
$user = User::loadUserById($connection, $userId);

$userName = $user->getUsername();
$messages = Message::loadAllMessagesByUserId($connection, $userId);
if (!empty($messages)) {

    $messagesSent = [];
    $messagesRecived = [];
    foreach ($messages as $message) {
        if ($message->getRecipient_id() == $userId) {
            $messagesRecived[] = $message;
        } else {
            $messagesSent[] = $message;
        }
    }
}


?>
<html lang="pl-PL">
    <head>
        <meta charset="utf-8">
        <title>Wiadomości</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <a class="home" href="index.php">Powrót na stronę główną</a>
        <h1>Wiadomości użytkownika <?php echo $userName ?></h1>
        <h2>Wiadomości otrzymane</h2>
        <h3>Czcionką pogrubioną zaznaczono wiadomości, których jeszcze nie przeczytałeś</h3>
        <table>


            <?php
            echo '<tr>';
            echo '<th>Nadawca</th>';
            echo '<th>Tekst</th>';
            echo '<th>Data</th>';
            if (!empty($messagesRecived)) {
                foreach ($messagesRecived as $message) {
                    $userId = $message->getSender_id();
                    $text = substr($message->getText(), 0, 30);
                    $user = User::loadUserById($connection, $userId);
                    $name = $user->getUsername();
                    echo '<tr>';

                    echo "<td><a href='usersite.php?userId=$userId'>$name</a></td>";
                    if ($message->getStatus() == 0) {
                        echo "<td><a href='message.php?messageId={$message->getId()}'><strong>$text</strong></a></td>";
                    } else {
                        echo "<td><a href='message.php?messageId={$message->getId()}'>$text</a></td>";
                    }

                    echo '<td>' . $message->getCreation_date() . '</td>';
                    echo '</tr>';
                }
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
            if (!empty($messagesSent)) {
                foreach ($messagesSent as $message) {
                    $userId = $message->getRecipient_id();
                    $text = substr($message->getText(), 0, 30);
                    
                    $user = User::loadUserById($connection, $userId);
                    $name = $user->getUsername();
                    echo '<tr>';
                    echo "<td><a href='usersite.php?userId=$userId'>$name</a></td>";
                    echo "<td><a href='message.php?messageId={$message->getId()}'>$text</a></td>";
                    echo '<td>' . $message->getCreation_date() . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </table>
    </body>
</html>
