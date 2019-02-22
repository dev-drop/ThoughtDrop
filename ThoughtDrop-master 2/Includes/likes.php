<?php
require "db.php";
//************************ WORK IN PROGRESS ******************
//************************************************************
if (isset($_POST['action'])) {
    
    switch ($_POST['action']) {
        case 'like':
            
            $statement = $pdo->prepare('INSERT INTO `likes` (`post_Id`, `employee_Id`) VALUES (?, ?)');
            $statement->execute([$employee_Id, $display_name, $hashedPass]);
            break;
            
        case 'comment':
           echo "comment Works";
            break;
    }
}
?>