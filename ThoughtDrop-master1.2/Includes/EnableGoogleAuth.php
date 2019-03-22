<?php
require "db.php"; require_once 'Includes/GoogleAuthenticator.php';

//**** ENABLE TWO-FACTOR AUTHENTICATOR ****
$ga = new PHPGangsta_GoogleAuthenticator();

function goAuthInit($ga)
{
    //SECRET CODE GENERATOR
    $secret = $ga->createSecret();
    $qrCodeUrl = $ga->getQRCodeGoogleUrl('ThoughtDropv1', $secret);
    return array($secret, $qrCodeUrl);

}

if(isset($_POST['submitCode'])){
        $mysecret = $_POST['secret'];
        $oneCode = $_POST['code'];
        $checkResult = $ga->verifyCode($mysecret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
        if ($checkResult) {
            $_SESSION['GoogleAuth'] = true;
            var_dump($_SESSION['GoogleAuth']);
            //echo "sucess";
            // SAVE SECRET TO DB IN USER PROFILE
            $statement = $pdo->prepare('UPDATE `employee` SET `secret` = ? WHERE `employee_Id` = ?');
            $statement->execute([$mysecret, $_SESSION['currentUser']]);

            //header('Location: http://localhost:8888/ThoughtDrop-master3/home.php');
        } else {
            $message = "Sorry, It appears something went wrong, please check your entry and try again.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

}
if(isset($_POST['submitDisCode'])){

        $mysecret = $_POST['secretDis'];
        $noSecret = "";
        $oneCode = $_POST['code'];
        $checkResult = $ga->verifyCode($mysecret, $oneCode, 2);
        if ($checkResult)
        {
            $_SESSION['GoogleAuth'] = false;
            $statement = $pdo->prepare('UPDATE `employee` SET `secret` = ? WHERE `employee_Id` = ?');
            $statement->execute([$noSecret, $_SESSION['currentUser']]);
        }else
        {
          $message = "Failed to delete. Please try again later.";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }
}



?>
