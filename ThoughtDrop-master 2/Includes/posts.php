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
    
//**** RETRIEVE 100 NEWEST POSTS ****    
$statement = $pdo->prepare('SELECT * FROM `posts` ORDER BY `timestamp` DESC LIMIT 100');
$statement->execute();
$result = $statement->fetchAll();
    
    if($result > 0) { 
        return $result;
    }
}

//**** FETCH USER INFO ****
function userProf($pdo){
   //SEARCH FOR USER PROFILE
    $statement = $pdo->prepare('SELECT * FROM `employee` WHERE `employee_Id` = ?');
    $statement->execute([$_SESSION['currentUser']]);
    $result = $statement->fetch();
    
    return $result;
}

//**** COMMIT NEW POST **** 
if(isset($_POST['postContent'])){
    if(!$currentUser){
        echo "Please Sign In";
        return;
    }else{
        
        //ASSIGN VALUES
        $authorId = $currentUser;
        $date = new DateTime();
        $timeStamp = $date->format('Y-m-d H:i:s');
        $postBody = $_POST['postBody'];
        if(!$postBody==""){
            //POST TO DB
            $statement = $pdo->prepare('INSERT INTO `posts` (`author_Id`, `timestamp`, `body`) VALUES (?, ?, ?)');
            $statement->execute([$authorId, $timeStamp, $postBody]);
        }else{
            
            return;
        }
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
function validate_permissions($currentUser, $Author){
        if($currentUser == $Author){
            //ENABLE PERMISSION TO EDIT / DELETE POST
            return true;
        }else{
            return false;
        }
    }

?>