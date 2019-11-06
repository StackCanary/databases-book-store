<?php
session_start(); 
require('autoload.php');

Login::if_login_needed();

$query = new Query();   //    echo $query->books()->num_rows;

$can_proceed = isset($_GET['isbn']);

$isbn = $_GET['isbn'];

$page = 0;

if (isset($_GET['page']))
  $page = (int) $_GET['page'];
else 
  $_GET['page'] = 0;

if (!$can_proceed)
  header('location: index.php');


$id = $_SESSION['person_id'];

try {
  $book = new Book($isbn);
} catch(Exception $e) {
  die('Could not find book');
}

?>

<html>

  <?php include("title.php"); ?>

  <div id="container">

    <table>
      <tr>
        <th>Book Title</th>
        <th>Author</th>
        <th>Duration</th>
        <th>Age Rating</th>
        <th>Price</th>
      </tr>

      <?php echo $book->print_entry(); ?>
      
    </table>

    <div style='text-align: center'>
      <h3>
        <?php
        if ($book->can_purchase($id))
          echo $book->purchase_link('Buy Now!');
        else
          echo 'You can listen to this book!';
        ?>
      </h3>
    </div>

    <div style='text-align: center'>
      <h2> Reviews </h2>
    </div>

    <table>
      <tr>
        <th>Review</th>
        <th>Rating</th>
      </tr>

      <?php

      $result = $book->get_reviews($page, 5);

      while ($row = $result->fetch_assoc()) {

        echo '<tr>' . '<td>' . $row['comment'] . '</td> <td>' . $row['rating'] . '</td> <td>' . '<tr/>';

      }

      
      
      ?>
      
    </table>

    <?php
    if (!$query->can_purchase($id, $isbn)) :
    ?>
      
      <div style='text-align: center'>
        
        <form action="review.php" method="POST">
          
          <input type="hidden" name="isbn" value="<?php echo $isbn; ?>" />
          
          <div>
            <select name="rating">
              <option value="1">1</option> 
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4" selected>4</option>
              <option value="5">5</option>
            </select>
          </div>
          
          <div>
            <textarea  type="text" name="review" placeholder="Review" rows="10" cols="40" required autocomplete="off"> </textarea>
          </div>
          
          <div>
            <input type="submit" value="Review" />
          </div>

        </form>

      </div>
      

    <?php endif; ?>

  </div>

  
</html>
