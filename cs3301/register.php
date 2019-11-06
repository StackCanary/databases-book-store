<html>

  <head>
    <link rel="stylesheet" type="text/css" href="login.css">
  </head> 
  
  <body>
    <div class="container">

      <div class="login">
        <h1 class="welcome">
          Register Here!</h1>
        
        <form action="register.php" method="POST">

          <div>
            <input name="name" type="name" placeholder="Name" class="input-txt" required autocomplete="off"/>
          </div>

          <div>
            <input name="email" type="email" placeholder="Email" class="input-txt" required autocomplete="off"/>
          </div>

          <div>
            <input type="date" name="dob" />
          </div>

          <div>
            <input name="password" type="password" placeholder="Password" class="input-txt" required autocomplete="off"/>
          </div>

          <div class="login-footer">
            <input type="submit" value="Register" class="sign-in-button" />
          </div>

          <div>
            Have an account? <a href="login.php">Login</a>
          </div>

        </form>
      </div>
      
    </div>
    
  </body>
</html>

<?php
   
session_start();
require('autoload.php');

$can_proceed = isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']);

if ($can_proceed)
  $register = new Register($_POST['name'], $_POST['email'], $_POST['dob'], $_POST['password']);
else
  die("Cannot proceed, missing values in registration form.");

   
?>
