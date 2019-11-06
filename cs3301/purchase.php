<?php
session_start(); 
require('autoload.php');

Login::if_login_needed();

$query = new Query();   //    echo $query->books()->num_rows;


// Should probably fix this CSRF vulnerability

$can_proceed = isset($_GET['isbn']);

if (!$can_proceed)
  die("Cannot proceed, isbn not set.");

$id   = $_SESSION['person_id'];
$isbn = $_GET['isbn'];

$query->purchase($id, $isbn);

header('location: books.php?isbn=' . $isbn);

?>
