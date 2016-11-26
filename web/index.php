<?php
include_once 'connection.php';
include_once '../src/Tweet.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tweets = Tweet::loadAllTweets($connection);
//var_dump($tweets);
?>
<html lang="pl-PL">
    <head>
        <meta charset="utf-8">
        <title>Strona główna</title>

    </head>
    <body>
        <table>

            <tr>
                <th>id</th>
                <th>user_id</th>
                <th>tweet_text</th>
                <th>creation_date</th>
            </tr>
            <?php
            
            foreach ($tweets as $tweet) {

                echo '<tr>';
                echo '<td>' . $tweet->getId() . '</td>';
                echo '<td>' . $tweet->getUserId() . '</td>';
                echo '<td>' . $tweet->getText() . '</td>';
                echo '<td>' . $tweet->getCreationDate() . '</td>';
                echo '</tr>';
            }
            ?>


        </table>


    </body>
</html>