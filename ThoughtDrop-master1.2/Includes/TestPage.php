<?php require 'db.php'; require 'login.php'; require 'posts.php'; require 'likes.php'; ?>


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>
 <br><br><br><br><br><br>
 
    <form action="" method="post">
    <button type="submit" name="logout">logout</button> 
    </form>
      
  <br><br><br><br><br><br>
   <label>Register</label>
   <form action="" method="post">
    <label for="employee_Id">Employee ID</label>
    <input type="text" name="employee_Id" maxlength="6">
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
    <input type="text" name="employee_Id" maxlength="6">
    <label for="password">Password</label>
    <input type="password" name="password">
    <button type="submit" name="login">Login</button>      
   </form>
   <br><br><br><br><br><br>
   <label>POST</label>
   <form action="" method="post">  
    <input type="" name="postBody">
    <button type="submit" name="postContent" maxlength="255">POST</button>      
   </form>
   <br><br>
   
    
    <!-- TEST AREA FOR NEW POSTS-->
    <!-- DUMPING THE POSTS FOR TESTING AND TO HELP WITH POSTS HTML SETUP -->
   <pre><?php init($pdo) ?></pre>
   
   
   
   <script>
$(document).ready(function(){
    $('.button').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'likes.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            //Response contains whatever is output from server
            console.log(response)
        });
    });

});
    
    
    
    
    
    </script>
  

   
</body>
</html>