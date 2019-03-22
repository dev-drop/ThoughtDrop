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
        
    case 'likeComment':
        
        // Required parameter of PostID
        if(!isset($_GET['commentId']))
            $json['error'] = "Comment Id is required";
        else
        {
            
            $json['status'] = 'Success';
            $commentId = $_GET['commentId'];
            $currentUser = $_SESSION['currentUser'];

            $statement = $pdo->prepare('INSERT IGNORE INTO `commentLikes` (`comment_Id`, `employee_Id`) VALUES (?, ?)');
            $statement->execute([$commentId, $currentUser]);
            
            
            $statement2 = $pdo->prepare('SELECT * FROM `commentLikes` WHERE `comment_Id` = ?');
            $statement2->execute([$commentId]);
            $result = $statement2->fetchAll();
            $count = count($result);
            $json['commentLikes'] = $count;
                    
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
        
    case 'seeUser':
        
        // Required parameter of PostID
        if(!isset($_GET['empId']))
            $json['error'] = "Employee Id is required";
        else
        {
            
            $json['status'] = 'Success';
            $empId = $_GET['empId'];
            
            $statement = $pdo->prepare('SELECT * FROM `employee` WHERE `employee_Id` = ?');
            $statement->execute([$empId]);
            $result = $statement->fetch();
            $json['userInfo'] = $result;
            
            // Get Comment Count
            $statement2 = $pdo->prepare('SELECT * FROM `comments` WHERE `author_Id` = ?');
            $statement2->execute([$empId]);
            $result2 = $statement2->fetchAll();
            $count2 = count($result2);
            $json['commentCount'] = $count2;
            
            
            // Get Like Count
            $statement3 = $pdo->prepare('SELECT * FROM `likes` WHERE `employee_Id` = ?');
            $statement3->execute([$empId]);
            $result3 = $statement3->fetchAll();
            $count3 = count($result3);
            $json['likeCount'] = $count3;   
            
            
                    
        }
        break;
        
    default:
        $json['error'] = 'Action "'.$action.'" does not exist';
        break;
}


//header('content-type: application/json');
die(json_encode($json));
?>
