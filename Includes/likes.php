<?php
require "db.php";

//************************ WORK IN PROGRESS ******************
//************************************************************

function getLikes($pdo, $postId){
   // Get Like Count
    $statement = $pdo->prepare('SELECT * FROM `likes` WHERE `post_Id` = ?');
    $statement->execute([$postId]);
    $result = $statement->fetchAll();

    //var_dump($result);
    $count = count($result);
    //$count = $result.count();
    return $count;

}

function userLikes($pdo, $employeeId){
    
    // Get Like Count
    $statement = $pdo->prepare('SELECT * FROM `likes` WHERE `employee_Id` = ?');
    $statement->execute([$employeeId]);
    $result = $statement->fetchAll();

    //var_dump($result);
    $count = count($result);
    //$count = $result.count();
    return $count;   
}





?>
