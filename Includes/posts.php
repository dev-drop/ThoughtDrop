<?php 
require "db.php";
date_default_timezone_set('America/Vancouver');

//**** ASSIGN EMPLOYEE ID TO SESSION AFTER LOGIN ****
if($_SESSION){
    $currentUser = $_SESSION['currentUser'];
}else{
    $currentUser = false;
}

//**** GET POSTS ****
function init($pdo){
$statement = $pdo->prepare('SELECT * FROM `posts`');
$statement->execute();
$result = $statement->fetchAll();
    
    if($result > 0) {
        
        //**** TESTING OUTPUT DATA FOR EACH ROW ****
        //TODO: ADD SEPARATE FORM FOR LIKES/COMMENTS
        for($i=0; $i<sizeof($result);$i++){
            echo "Post_Id: " . $result[$i]["Id"]." ";
            echo "Author_Id: " . $result[$i]["author_Id"]." ";
            echo "TimeStamp: " . $result[$i]["timestamp"]." ";
            echo "Content: " . $result[$i]["body"]." ";
            //echo '<input type="submit" class="button" name="like" value="like" />';
            echo "Likes: " . $result[$i]["likes"]." ";
            //echo '<input type="submit" class="button" name="comment" value="comment" />';
            echo "Comments: " . $result[$i]["comments"]." ";
            validate_permissions($_SESSION['currentUser'], $result[$i]['author_Id'], $result[$i]['Id'], $result[$i]['body']);
        }
    }else {
        echo "0 results";
    }       
}

//**** COMMIT NEW POST **** 
if(isset($_POST['postContent'])){
    if(!$currentUser){
        echo "Please Sign In";
        return;
    }else{
        //VARDUMP FOR TESTING USER SESSION DATA
        var_dump("Current User: ".$currentUser);

        //ASSIGN VALUES
        $authorId = $currentUser;
        $date = new DateTime();
        $timeStamp = $date->format('Y-m-d H:i:s');
        $postBody = $_POST['postBody'];

        //POST TO DB
        $statement = $pdo->prepare('INSERT INTO `posts` (`author_Id`, `timestamp`, `body`) VALUES (?, ?, ?)');
        $statement->execute([$authorId, $timeStamp, $postBody]);
    }
}

//**** DELETE POST ****
if(isset($_POST['delete'])){
   
    //TODO : CONFIRM DELETION OF THE POST 
    
    //DEFINE THE POST TO BE SEARHCED FOR AND DELETED
    $postId = $_POST['postId'];
    $statement = $pdo->prepare('DELETE FROM `posts` WHERE `Id` = ?');
    $statement->execute([$postId]);
}

//**** EDIT POST ****
if(isset($_POST['edit'])){
    
    $postId = $_POST['postId'];
    $newBody = $_POST['body'];
    $statement = $pdo->prepare('UPDATE `posts` SET `body` = ? WHERE `Id` = ?');
    $statement->execute([$newBody, $postId]);
}

//**** CHECK USER FOR POST MATCHES. ENABLE EDITING PERMISSIONS ****
function validate_permissions($currentUser, $Author, $Id, $body){
        if($currentUser == $Author){
        
        //TODO: HIDE EDIT FIELD UNTIL BUTTON SELECTED. SHOW EDIT IN NEW WINDOW / MODAL
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="postId" value="'.$Id.'" />';
        echo '<input type="text" name="body" value="'.$body.'" />';
        echo '<button type="submit" name="edit">Edit</button>'; 
        echo '</form>';
        
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="postId" value='.$Id.' />';
        echo '<button type="submit" name="delete">Delete</button>'; 
        echo '</form>';    
        

        //ENABLE PERMISSION TO EDIT / DELETE POST
        }else{
            echo "\n";
        }
    }

?>