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
function allPosts($pdo){

//**** RETRIEVE 100 NEWEST POSTS ****
$statement = $pdo->prepare('SELECT * FROM `posts` ORDER BY `timestamp` DESC LIMIT 100');
$statement->execute();
$result = $statement->fetchAll();

    if($result > 0) {
        return $result;
    }
}

//**** GET POSTS FROM R&D *****
function rdPosts($pdo){


$statement = $pdo->prepare('SELECT * FROM `posts` WHERE substring(`author_Id`, 1, 1) = "R" ORDER BY `timestamp` DESC LIMIT 100');
$statement->execute();
$result = $statement->fetchAll();

    if($result > 0) {
        return $result;
    }
}

//**** GET POSTS FROM MARKETING *****
function msPosts($pdo){


$statement = $pdo->prepare('SELECT * FROM `posts` WHERE substring(`author_ID`, 1, 1) = "M" ORDER BY `timestamp` DESC LIMIT 100');
$statement->execute();
$result = $statement->fetchAll();

    if($result > 0) {
        return $result;
    }
}

//**** GET POSTS FROM ADMIN *****
function adPosts($pdo){


$statement = $pdo->prepare('SELECT * FROM `posts` WHERE substring(`author_ID`, 1, 1) = "A" ORDER BY `timestamp` DESC LIMIT 100');
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
        $postBody = htmlspecialchars($_POST['postBody'],ENT_COMPAT | ENT_XHTML,'utf-8');
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

    //DEFINE THE POST TO BE SEARCHED FOR AND DELETED
    $postId = $_POST['postId'];
    $statement = $pdo->prepare('DELETE FROM `posts` WHERE `Id` = ?');
    $statement->execute([$postId]);
}

//**** EDIT POST ****
if(isset($_POST['edit'])){
    $postId = $_POST['postId'];
    $newBody = htmlspecialchars($_POST['body'],ENT_COMPAT | ENT_XHTML,'utf-8');;

    if(!$newBody ==""){

        $statement = $pdo->prepare('UPDATE `posts` SET `body` = ? WHERE `Id` = ?');
        $statement->execute([$newBody, $postId]);
      }else{
        $message = "The post body cannot be left empty";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }

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
