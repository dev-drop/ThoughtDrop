<?php
require 'Includes/db.php';

//**** INITIATE SESSION FOR USER *****
session_name('TDSession');
session_start();

$action = isset($_GET['action']) ? $_GET['action'] : null;
$json = ['status' => 'Failed'];


switch ($action)
{
    case 'likePost':
        
        // Required parament of PostID
        if(!isset($_GET['postId']))
            $json['error'] = "Post Id is required";
        else
        {
            
            $json['status'] = 'Success';
            $postId = $_GET['postId'];
            $currentUser = $_SESSION['currentUser'];

            // Send Like to DB
            $statement = $pdo->prepare('INSERT INTO `likes` (`post_Id`, `employee_Id`) VALUES (?, ?)');
            $statement->execute([$postId, $currentUser]);
            
            
            $statement2 = $pdo->prepare('SELECT * FROM `likes` WHERE `post_Id` = ?');
            $statement2->execute([$postId]);
            $result = $statement2->fetchAll();
            $count = count($result);
            $json['likes'] = $count;
            
            
            
                
        }
        break;
        
    case 'getComments':
        
        if(!isset($_GET['postId']))
            $json['error'] = "Post Id is required";
        else
        {
            
            $json['status'] = 'Success';
            $postId = $_GET['postId'];
            
            // Send Like to DB
            $statement = $pdo->prepare('SELECT * FROM `comments` WHERE `post_Id` = ?');
            $statement->execute([$postId]);
            $result = $statement->fetchAll();
            $json['comments'] = $result;
            
            $statement2 = $pdo->prepare('SELECT * FROM `comments` WHERE `post_Id` = ?');
            $statement2->execute([$postId]);
            $result2 = $statement2->fetchAll();
            $count = count($result2);
            $json['commentCount'] = $count;
            
                
        }
        break;
    default:
        $json['error'] = 'Action "'.$action.'" does not exist';
        break;
}


//header('content-type: application/json');
die(json_encode($json));
?>