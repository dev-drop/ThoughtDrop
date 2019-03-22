<?php require 'Includes/db.php'; require 'Includes/login.php'; ?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThoughtDrop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">


    <link rel="stylesheet" href="styles/main.css">


</head>
<body class="loginpage">

<div>
  <div class="wrapper">
    <div id="formContent">
      <!-- Tabs Titles -->

      <!-- Icon -->
      <div class="fadeIn first">
        <img src="images/TDLogo300.png" id="icon" alt="ThoughtDrop" />
      </div>

      <!-- Login Form -->
      <form class="loginform" action="" method="POST">
        <?php
        if(isset($_POST["employee_Id"]))
         echo '<div class="error">Invalid Username or Password</div>';
        ?>
        <input type="text" name="employee_Id" placeholder="Employee ID" maxlength="6">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="authenticate" placeholder="GoogleAuthenticate ( if enabled )" maxlength="6">
        <input type="submit" name="login" value="Log In">
      </form>


      <!-- Registration Form -->
      <form class="registrationform" action="" method="POST">
        <input type="text" name="employee_Id" placeholder="Enter Your Employee ID" maxlength="6">
        <input type="text" name="display_name" placeholder="Enter Your User Name">
        <input type="password" name="password" placeholder="Enter Your Password">
        <input type="submit" name="register" value="Register">
      </form>

      <!-- Footer with links -->
      <div id="formFooter">
        <div id="registerlink">New to ThoughtDrop? <a class="underlineHover" href="#">Register here</a></div>
        <div id="loginlink">Already a User? <a class="underlineHover" href="#">Login here</a></div>
      </div>
    </div>
  </div>
</div>

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="scripts/scripts.js"></script>
<body>
</html>
