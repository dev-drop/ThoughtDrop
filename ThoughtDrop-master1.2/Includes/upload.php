<?php
require "db.php";

if($_SESSION['currentUser']){

$user = $_SESSION['currentUser'];


// Check if image file is a actual image or fake image
if(isset($_POST["submitImage"])) {
    $target_dir = "uploads/".$user;
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

    if($check !== false) {
        $message = "File is an image - " . $check["mime"] . ".";
        //echo "<script type='text/javascript'>alert('$message');</script>";

        $uploadOk = 1;
    } else {
        $message = "File is not an image.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $uploadOk = 0;
    }
    // Check if file already exists
if (file_exists($target_file)) {
    $message = "Sorry, file already exists.";
    //echo "<script type='text/javascript'>alert('$message');</script>";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    $message = "Sorry, your file is too large.";
    echo "<script type='text/javascript'>alert('$message');</script>";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    echo "<script type='text/javascript'>alert('$message');</script>";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $message = "Sorry, your file was not uploaded.";
    echo "<script type='text/javascript'>alert('$message');</script>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        // INSERT IMAGE FILE
            $image = $target_file;
            $statement = $pdo->prepare('UPDATE `employee` SET `thumbnail` = ? WHERE `employee_Id` = ?');
            $statement->execute([$image, $_SESSION['currentUser']]);


        $message = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        //echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $message = "Sorry, there was an error uploading your file.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
}

}
?>
