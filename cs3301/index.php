<?php
session_start(); 
require('autoload.php');

Login::if_login_needed();

$query = new Query();   //    echo $query->books()->num_rows;

header('location: browse.php');

?>

<html>

  <?php include("title.php"); ?>

  
  
</html>


