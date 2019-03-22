<?php
require "db.php";

date_default_timezone_set('America/Vancouver');

// Comment Form Submission
if(isset($_POST['commentSubmit'])){
    //$comment = $_POST['commentBody'];
    $commentBody = htmlspecialchars($_POST['commentBody'],ENT_COMPAT | ENT_XHTML,'utf-8');
    $cusfreeBody = wordFilter($commentBody);
    $post_Id = $_POST['post_Id'];
    $authorId = $_SESSION['currentUser'];
    $date = new DateTime();
    $timeStamp = $date->format('Y-m-d H:i:s');

    if(!$cusfreeBody == ""){
        // POST TO DD
            $statement = $pdo->prepare('INSERT INTO `comments` (`author_Id`, `timestamp`, `body`, `post_Id`) VALUES (?, ?, ?, ?)');
            $statement->execute([$authorId, $timeStamp, $cusfreeBody, $post_Id]);
    }else{
      $message = "The post body cannot be left empty";
      echo "<script type='text/javascript'>alert('$message');</script>";
      return;
    }

}

function getCommentCount($pdo, $postId){
   // Get Comment Count
    $statement = $pdo->prepare('SELECT * FROM `comments` WHERE `post_Id` = ?');
    $statement->execute([$postId]);
    $result = $statement->fetchAll();
    $count = count($result);

    return $count;
}

function userComments($pdo, $employeeId){
    
    // Get Like Count
    $statement = $pdo->prepare('SELECT * FROM `comments` WHERE `author_Id` = ?');
    $statement->execute([$employeeId]);
    $result = $statement->fetchAll();

    //var_dump($result);
    $count = count($result);
    //$count = $result.count();
    return $count;   
}


?>
