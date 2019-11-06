<html>

  <head>
    <link rel="stylesheet" type="text/css" href="login.css">
  </head> 
  
  <body>

    <div class="container">

      <div class="login">
        
        <h1 class="welcome">
          <strong>Welcome.</strong> Please login.</h1>
        
        <form action="login.php" method="POST">
          <div>

            <input name="email" type="username" placeholder="Email" class="input-txt" required autocomplete="off"/>
          </div>

          <div>
            <input name="password" type="password" placeholder="Password" class="input-txt" required autocomplete="off"/>
          </div>

          <div class="login-footer">
            <input type="submit" value="Sign In" class="sign-in-button" />
          </div>

          <div>
            Don't have an account? <a href="register.php">Sign up</a>
          </div>

        </form>
      </div>
      
    </div>
    
  </body>
</html>


<?php

session_start(); 
require('autoload.php');

Login::if_already_logged_in();


$can_proceed = isset($_POST['email']) && isset($_POST['password']);


if ($can_proceed) {
  
  $login = new Login($_POST['email'], $_POST['password']);

  $login->do_login();

  Login::if_already_logged_in();

}

?>
