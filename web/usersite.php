<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'connection.php';
include_once '../src/Tweet.php';
include_once '../src/User.php';
include_once '../src/Comment.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_GET['userId'];
    if (!empty($userId) && is_numeric($userId)) {
        $user = User::loadUserById($connection, $userId);
        $userName = $user->getUsername();
    } else {
        echo 'metodą get przesłano niepoprawne dane';
    }
}
//$userId = $_SESSION['user'];
//$user = User::loadUserById($connection, $userId);
//$userName = $user->getUsername();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
}
?>

<html lang="pl-PL">
    <head>
        <meta charset="utf-8">
        <title>Strona główna</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Użytkownik <?php echo $userName ?></h1>

        <h2>Poniżej wszystkie wysłane przez tego użytkownika tweety</h2>
        <table>

            <tr>

                <th>Tweet</th>
                <th>liczba komentarzy</th>
                <th>data</th>
            </tr>
            <?php
            $tweets = Tweet::loadAllTweetsByUserId($connection, $userId);
            foreach ($tweets as $tweet) {
                $id = $tweet->getId();
                $comments = Comment::loadAllCommentsByPostId($connection, $id);
                $numberOfComments = count($comments);
                echo '<tr>';

                echo "<td><a href='post.php?tweetId={$tweet->getId()}'>{$tweet->getText()}</a></td>";
                echo "<td>$numberOfComments</td>";
                echo '<td>' . $tweet->getCreationDate() . '</td>';
                echo '</tr>';
            }
            ?>
        </table>

        <form action='messages.php?recipientId=<?php echo $userId?>' method="POST">
            <label>
                <h3>Tekst wiadomości do tego użytkownika:</h3>
                <textarea cols="50" rows="8" name="message"></textarea>
            </label>
            <p>
                <button type="submit">Wyślij wiadomość</button>
            </p>
        </form>

    </body>
</html>