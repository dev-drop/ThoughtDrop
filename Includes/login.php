<?php
require "db.php"; require_once 'Includes/GoogleAuthenticator.php';

//**** ENABLE TWO-FACTOR AUTHENTICATOR ****
$ga = new PHPGangsta_GoogleAuthenticator();

//**** INITIATE SESSION FOR USER *****
session_name('TDSession');
session_start();


//**** REGISTRATION *****
if(isset($_POST['register'])){

    //FORM INPUT FIELDS
    $employee_Id = ucfirst($_POST['employee_Id']);
    $display_name = $_POST['display_name'];
    $password = $_POST['password'];

    $validIdFormat = preg_match('/^[a-zA-Z]{1}[0-9]{5}$/', $employee_Id, $output_array);
    if($validIdFormat == 1){
        
        //HASH PASSWORD
        $options = ['cost' =>12];
        $hashedPass = password_hash($password, PASSWORD_BCRYPT, $options);

        //CHECK FOR EXISTING USER
        if(!userExists($employee_Id, $pdo)){

            //PREARE & EXECUTE SQL REGISTER USER DATA
            $statement = $pdo->prepare('INSERT INTO `employee` (`employee_Id`, `display_name`, `password`, `role`) VALUES (?, ?, ?, 10)');
            $statement->execute([$employee_Id, $display_name, $hashedPass]);
            $_SESSION['currentUser'] = $employee_Id;
            $_SESSION['userRole'] = 10;
            $_SESSION['GoogleAuth'] = false;
            
            header("Location: http://localhost:8888/ThoughtDrop-master1.6/home.php");
            //exit();
        }
    }else{
        return;
    }
}

//**** NEW ID VALIDATION ****
function userExists($employee_Id, $pdo){

    //SEARCH EMPLOYEE TABLE FOR THE REGISTERING ID
    $statement = $pdo->prepare('SELECT * FROM `employee` WHERE `employee_Id` = ?');
    $statement->execute([$employee_Id]);
    $result = $statement->fetch();
    if($result){
        return true;
    }else{
        return false;
    }
}

//**** LOGIN VERIFICATION ****
if(isset($_POST['login'])){

    //FORM INPUT FIELDS
    $employee_Id = $_POST['employee_Id'];
    $password = $_POST['password'];
    $googleauth = $_POST['authenticate'];

    //SEARCH FOR ID AND PASSWORD MATCH (ID IS UNIQUE TO USER)
    $statement = $pdo->prepare('SELECT * FROM `employee` WHERE `employee_Id` = ?');
    $statement->execute([$employee_Id]);
    $result = $statement->fetch();

    //var_dump($result);
    if($result){

        if(!empty($result['secret']))
        {
            $checkResult = $ga->verifyCode($result['secret'], $googleauth, 2);    // 2 = 2*30sec clock tolerance
            if ($checkResult) {

                $_SESSION['GoogleAuth'] = true;
                
                // STORE USERS PASSWORD
                $HashPass = $result['password'];

                // VERIFY INPUT PASSWORD AND SAVED HASHED-PASSWORD MATCH
                $passVerified = password_verify($password, $HashPass);
                if($passVerified){
                    
                    // TO:DO SOMETHING HERE WHEN VERIFIED
                    $_SESSION['currentUser'] = $result['employee_Id'];
                    $_SESSION['userRole'] = $result['role'];
                    
                    // REHASH
                    $options = ['cost'=>12];
                    $isOld = password_needs_rehash($password, PASSWORD_BCRYPT, $options);
                    if($isOld){

                        // Update the Hash Cost if the Value is Old
                        $hash = password_hash($password, PASSWORD_BCRYPT, $options);
                        $statementNewPass = $pdo->prepare('UPDATE `employee` SET `password` = ? WHERE `employee_Id` = ? ');
                        $statementNewPass->execute([$hash, $_SESSION['currentUser']]);

                    }
                  
                    header("Location: http://localhost:8888/ThoughtDrop-master1.6/home.php");

                    exit();
                }else{
                  $message = "Password Invalid";
                  echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        }else{
            // STORE USERS PASSWORD
                $HashPass = $result['password'];
                $_SESSION['GoogleAuth'] = false;
            
                // VERIFY INPUT PASSWORD AND SAVED HASHED-PASSWORD MATCH
                $passVerified = password_verify($password, $HashPass);
                if($passVerified){
                    
                    // TO:DO SOMETHING HERE WHEN VERIFIED
                    $_SESSION['currentUser'] = $result['employee_Id'];
                    $_SESSION['userRole'] = $result['role'];
                    
                    // REHASH
                    $options = ['cost'=>12];
                    $isOld = password_needs_rehash($password, PASSWORD_BCRYPT, $options);
                    if($isOld){

                        // Update the Hash Cost if the Value is Old
                        $hash = password_hash($password, PASSWORD_BCRYPT, $options);
                        $statementNewPass = $pdo->prepare('UPDATE `employee` SET `password` = ? WHERE `employee_Id` = ? ');
                        $statementNewPass->execute([$hash, $_SESSION['currentUser']]);

                    }
            
                    header("Location: http://localhost:8888/ThoughtDrop-master1.6/home.php");

                    exit();
                }
        }
    }
}



//****DELETE USERS *********//
if(isset($_POST['deleteUser']))
{
      //DEFINE THE employee TO BE SEARCHED FOR AND DELETED
      $employeeId = $_POST['employeeId'];
      $statement = $pdo->prepare('DELETE FROM `employee` WHERE `employee_Id` = ?');
      $statement->execute([$employeeId]);

}

//**** LOG OUT ****
if(isset($_POST['logout'])){

    //TODO : LOGOUT FUNCTION
    Unset($_SESSION['currentUser']);
    Unset($_SESSION['GoogleAuth']);

    header("Location: http://localhost:8888/ThoughtDrop-master1.6/");

    exit();
}

?>
