<?php
include_once 'connection.php';
include_once '../src/Tweet.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$userId = 2;
//var_dump($tweets);
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!empty($_POST['sent']) && !empty($_POST['textTweeta'])){
        $tweet = new Tweet();
        $tweet->setText($_POST['textTweeta']);
        $tweet->setUserId($userId);
        $tweet->setCreationDate(date('Y-m-d H:i:s'));
        $tweet->saveToDb($connection);
    
    } else {
        echo 'metodą post przesłano za mało danych';    
    }
    //var_dump($_POST);
}
?>
<html lang="pl-PL">
    <head>
        <meta charset="utf-8">
        <title>Strona główna</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>To wszystkie tweety wysłane w naszym serwisie</h1>
        <h2>Jeśli chcesz znać więcej szczegółów kliknij w tekst tweetu</h2>
        <table>

            <tr>
                
                <th>Tweet</th>
                <th>data</th>
            </tr>
            <?php
            $tweets = Tweet::loadAllTweets($connection);
            foreach ($tweets as $tweet) {

                echo '<tr>';
               
                echo "<td><a href='post.php?tweetId={$tweet->getId()}'>{$tweet->getText()}</a></td>";
                echo '<td>' . $tweet->getCreationDate() . '</td>';
                echo '</tr>';
            }
            ?>


        </table>
        <hr>
        <hr>
        <form action="#" method="POST">
            <label>
                <h2>Dodaj nowy tweet (max. liczba znaków to 140)</h2>
                <textarea cols="50" rows="10" name="textTweeta"></textarea>
            </label>
            <p>
            <input type="submit" name="sent" value="Wyślij">
            </p>
        </form>

    </body>
</html>