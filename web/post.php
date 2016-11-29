<?php
include_once 'connection.php';
include_once '../src/Tweet.php';
include_once '../src/User.php';
include_once '../src/Comment.php';

session_start();
$user_id = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
    $tweetId = $_GET['tweetId'];
    $_SESSION['tweetId'] = $_GET['tweetId'];

    if (isset($tweetId) && is_numeric($tweetId)) {
        $tweet = Tweet::loadTweetById($connection, $tweetId);
        $userId = $tweet->getUserId();
        $user = User::loadUserById($connection, $userId);
        $userName = $user->getUsername();
        $text = $tweet->getText();
        $data = $tweet->getCreationDate();
        
    }

}



if ($_SERVER['REQUEST_METHOD']==='POST'){
    
    if(!empty($_POST['comment']) &&!empty($_POST['sent'])){
        $tweetId = $_SESSION['tweetId'];
        $comm = new Comment();
        $comm->setText($_POST['comment']);
        $comm->setUser_id($user_id);
        $comm->setTweet_id($tweetId);
        $comm->setCreation_date(date('Y-m-d H:i:s'));
        $comm->saveToDb($connection);
        
        $tweet = Tweet::loadTweetById($connection, $tweetId);
        $userId = $tweet->getUserId();
        $user = User::loadUserById($connection, $userId);
        $userName = $user->getUsername();
        $text = $tweet->getText();
        $data = $tweet->getCreationDate();
        
    } else {
        $tweetId = $_SESSION['tweetId'];
        $tweet = Tweet::loadTweetById($connection, $tweetId);
        $userId = $tweet->getUserId();
        $user = User::loadUserById($connection, $userId);
        $userName = $user->getUsername();
        $text = $tweet->getText();
        $data = $tweet->getCreationDate();
    echo 'nie można wysyłać pustych komentarzy';    
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
        <a class="home" href="index.php">Powrót na stronę główną</a>
        <h2>Poniżej informacje o tweecie</h2>
        <table>
            <tr>
                <th>Autor</th>
                <th>Tweet</th>
                <th>Data</th>
            </tr>
            <tr>
            <?php
            echo "<td><a href='usersite.php?userId=$userId'>$userName</a></td>";
            echo "<td>$text</td>";
            echo "<td>$data</td>";
            ?>
            </tr>
        </table>
        <hr>
        <table>
            
            
            <?php
            $comments = Comment::loadAllCommentsByPostId($connection, $tweetId);
            if(!empty($comments)){
                echo '<tr>';
                echo '<th>Autor</th>';
                echo '<th>Komentarz</th>';
                echo '<th>Data</th>';
               foreach ($comments as $comment) {
                $userId = $comment->getUser_id();
                $user = User::loadUserById($connection, $userId);
                $name = $user->getUsername();
                echo '<tr>';
               
                echo "<td><a href='usersite.php?userId=$userId'>$name</a></td>";
                echo '<td>'.$comment->getText().'</td>';
                echo '<td>' . $comment->getCreation_date() . '</td>';
                echo '</tr>';
            } 
            } else {
            echo '<p>Ten tweet nie ma jeszcze komentarzy</p>';    
            }
            
            ?>
        </table>
        <form action="#" method="POST">
            <label>
                <h3>Dodaj nowy komentarz (max. liczba znaków to 60)</h3>
                <textarea cols="50" rows="10" name="comment"></textarea>
            </label>
            <p>
            <input type="submit" name="sent" value="Wyślij">
            </p>
        </form>
    </body>
</html>
