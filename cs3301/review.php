<?php
session_start(); 
require('autoload.php');

Login::if_login_needed();

$query = new Query();

$can_proceed = isset($_POST['review']) && isset($_POST['rating']) && isset($_POST['isbn']);

if (!$can_proceed)
  die("Cannot proceed");

$id     = $_SESSION['person_id'];

$isbn   = $_POST['isbn'];
$review = $_POST['review'];
$rating = (int) $_POST['rating'];


if (!$query->can_purchase($id, $isbn)) {

  $query->leave_review($id, $isbn, strip_tags($review), $rating);
  
}
  
  
header('location: book.php?isbn=' . $isbn);


?>
