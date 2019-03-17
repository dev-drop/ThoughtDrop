<?php 
require "db.php";

date_default_timezone_set('America/Vancouver');

// Comment Form Submission
if(isset($_POST['commentSubmit'])){
    
    //$comment = $_POST['commentBody'];
    $commentBody = htmlspecialchars($_POST['commentBody'],ENT_COMPAT | ENT_XHTML,'utf-8');
    $post_Id = $_POST['post_Id'];
    $authorId = $_SESSION['currentUser'];
    $date = new DateTime();
    $timeStamp = $date->format('Y-m-d H:i:s');
    
    if(!$commentBody == ""){
            
        // POST TO DD
            $statement = $pdo->prepare('INSERT INTO `comments` (`author_Id`, `timestamp`, `body`, `post_Id`) VALUES (?, ?, ?, ?)');
            $statement->execute([$authorId, $timeStamp, $commentBody, $post_Id]);
        }else{

            return;
        }
    
};

function getCommentCount($pdo, $postId){
   
    
   // Get Comment Count
    $statement = $pdo->prepare('SELECT * FROM `comments` WHERE `post_Id` = ?');
    $statement->execute([$postId]);
    $result = $statement->fetchAll();
    $count = count($result);
    
    return $count;
    
}


?>