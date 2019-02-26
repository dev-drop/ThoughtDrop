<?php
require "db.php";
//**** INITIATE SESSION FOR USER *****
session_name('TDSession');
session_start();


//**** REGISTRATION *****
if(isset($_POST['register'])){

    //FORM INPUT FIELDS
    $employee_Id = $_POST['employee_Id'];
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
            $statement = $pdo->prepare('INSERT INTO `employee` (`employee_Id`, `display_name`, `password`) VALUES (?, ?, ?)');
            $statement->execute([$employee_Id, $display_name, $hashedPass]);
            $_SESSION['currentUser'] = $employee_Id;
            header("Location: http://localhost:8888/ThoughtDrop/home.php");
            //exit();
        }else{
            //Echo "Sorry, There is already a user by that Name";
        }
    }else{
        echo "Sorry, Id is incorrect Format";
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

    //SEARCH FOR ID AND PASSWORD MATCH (ID IS UNIQUE TO USER)
    $statement = $pdo->prepare('SELECT * FROM `employee` WHERE `employee_Id` = ?');
    $statement->execute([$employee_Id]);
    $result = $statement->fetch();
    //var_dump($result);
    if($result){

        //STORE USERS PASSWORD
        $HashPass = $result['password'];

        //VERIFY INPUT PASSWORD AND SAVED HASHED-PASSWORD MATCH
        $passVerified = password_verify($password, $HashPass);
        if($passVerified){
            //TO:DO SOMETHING HERE WHEN VERIFIED
            $_SESSION['currentUser'] = $result['employee_Id'];
            header("Location: http://localhost:8888/ThoughtDrop/home.php");
            exit();
        }else{
            //echo "Password incorrect";
        }
    }else{
        //echo "Sorry, User Not Found";
    }
}

//**** LOG OUT ****
if(isset($_POST['logout'])){

    //TODO : LOGOUT FUNCTION
    Unset($_SESSION['currentUser']);
    header("Location: http://localhost:8888/Thoughtdrop");
    exit();
}

?>
