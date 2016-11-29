<?php
include_once 'connection.php';
include_once '../src/Tweet.php';
include_once '../src/User.php';

session_start();
if(isset($_SESSION['user'])){
    $userId = $_SESSION['user'];
} else {
    
    header("Location: ../index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['sent']) && !empty($_POST['textTweeta'])) {
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
        <h1>Strona główna</h1>
        <a class="home" href="messages.php">Zobacz swoje wiadomości</a>
        <br>
        <br>
        <a class="home" href="editing.php">Zmień swoje dane</a>
        <br>
        <br>
        <a class="home" href="../index.php?logout=1">Wyloguj</a>
        <form action="#" method="POST">
            <label>
                <h2>Dodaj nowy tweet (max. liczba znaków to 140)</h2>
                <textarea cols="50" rows="10" name="textTweeta"></textarea>
            </label>
            <p>
                <input type="submit" name="sent" value="Wyślij">
            </p>
        </form>
        <hr>
        <hr>
        <h1>To wszystkie tweety wysłane w naszym serwisie</h1>
        <h2>Jeśli chcesz znać więcej szczegółów kliknij w tekst tweetu</h2>
        <table>

            <tr> 
                <th>Autor</th>
                <th>Tweet</th>
                <th>data</th>
            </tr>
            <?php
            $tweets = Tweet::loadAllTweets($connection);

            foreach ($tweets as $tweet) {
                $userId = $tweet->getUserId();
                $user = User::loadUserById($connection, $userId);
                $userName = $user->getUsername();
                echo '<tr>';
                echo "<td><a href='usersite.php?userId={$tweet->getUserId()}'>$userName</a></td>";
                echo "<td><a href='post.php?tweetId={$tweet->getId()}'>{$tweet->getText()}</a></td>";
                echo '<td>' . $tweet->getCreationDate() . '</td>';
                echo '</tr>';
            }
            ?>


        </table>



    </body>
</html>