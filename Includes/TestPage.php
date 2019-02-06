<?php require 'db.php'; require 'login.php'; ?>


<!-- *********************************************************************** -->
<!-- *********************************************************************** -->



<!--IN THIS HTML PAGE IM JUST TESTING THE BACKEND USING THESE RANDOM FORMS -->
<!--  THE INPUT FIELDS ARE NAMED APPROPRIATELY IN THE FORMS TO MATCH THE BACKEND -->



<!-- *********************************************************************** -->
<!-- *********************************************************************** -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staging and Testing Page For Specific Forms</title>
</head>
<body><br><br><br><br><br><br>
   <label>Register</label>
   <form action="" method="post">
    <label for="employee_Id">Employee ID</label>
    <input type="text" name="employee_Id">
    <label for="display_name">Display Name</label>
    <input type="text" name="display_name">
    <label for="password">Password</label>
    <input type="password" name="password">
    <button type="submit" name="register">Register</button>      
   </form>
   <br><br>
   <label>Login</label>
   <form action="" method="post">
    <label for="employee_Id">Employee ID</label>
    <input type="text" name="employee_Id">
    <label for="password">Password</label>
    <input type="password" name="password">
    <button type="submit" name="login">Login</button>      
   </form>
</body>
</html>