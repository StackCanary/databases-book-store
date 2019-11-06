<?php
session_start(); 
require('autoload.php');

Login::if_login_needed();

$query = new Query();


$page = 0;

if (isset($_GET['page']))
  $page = (int) $_GET['page'];
else 
  $_GET['page'] = 0;

if (isset($_GET['id']))
  $id = (int) $_GET['id'];
else
  $id = 0;

?>

<html>
  
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
    
  <?php include("title.php") ?>

  <div id="container">


    <table>
      <tr>
        <th>Book Title</th>
        <th>Duration</th>
        <th>Author</th>
        <th>Age Rating</th>
        <th>Price</th>
      </tr>
      
      <?php
  $result = $query->books_by_author($page, 12, $id);
      /* fetch associative array */
      while ($row = $result->fetch_assoc()) {
        $book = new Book($row['isbn']);
        
        echo $book->print_entry();
      }
      ?>
      
    </table>

    <div id="footer">

      <ul>
         <li><a href=<?php echo '"author.php?page=0&id=' . $id . '"'; ?> >0</a></li>
      </ul>

    </div>

  </div>
  
</html>
