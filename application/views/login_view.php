<?php

?>

<!DOCTYPE html>
<html lang="en">
    
<head>
   <title>Snapto-ur - Login</title>
</head>
 <body>
   <h1>Enter your username and password</h1>
   <?php echo validation_errors(); ?>
   <?php echo form_open('login/verify'); ?>
     <label for="username">Username:</label>
     <input type="text" size="20" id="username" name="username"/>
     <br/>
     <label for="password">Password:</label>
     <input type="password" size="20" id="passowrd" name="password"/>
     <br/>
     <input type="submit" value="Login"/>
   </form>
 </body>
</html>

