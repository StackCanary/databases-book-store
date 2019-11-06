<?php

class Book
{

  public $isbn;
  public $book_title;
  public $duration;
  public $age_rating;
  public $price;

  public $query;

  public $author_id;
  public $author_name;

  public $rating;

  function Book($isbn)
  {
    $this->query = new Query();

    $res = $this->query->book($isbn);

    if ($res->num_rows != 1)
      throw new Exception("Book doesn't exist!");

    $row = $res->fetch_assoc();

    $this->isbn       = $row['isbn'];
    $this->book_title = $row['book_title'];
    $this->duration   = $row['duration'];
    $this->age_rating = $row['age_rating'];
    $this->price      = $row['price'];

    $res = $this->query->author($isbn);
    $row = $res->fetch_assoc();

    $this->author_id = $row['author'];
    $this->author_name = $row['name'];

    
    
  }

  function purchase_link($content)
  {
    return "<a href='purchase.php?isbn=" . $this->isbn . "'>" . $content . "</a>";
  }

  function book_link($content)
  {
    return "<a href='book.php?isbn=" . $this->isbn . "'>" . $content . "</a>";
  }

  function author_link($content)
  {
    return "<a href='author.php?id=" . $this->author_id . "'>" . $content . "</a>";
  }

  function get_duration()
  {
    return gmdate("H:i:s", $this->duration);
  }

  function print_entry()
  {
    return '<tr>' . '<td>' . $this->book_link($this->book_title) . '</td>  <td>' . $this->author_link($this->author_name) . '</td> <td>' . $this->get_duration() . '</td> <td>' .  $this->age_rating . '+</td> <td>£' . $this->price . '</td> <tr/>';
  }
    
  function get_reviews($page, $results_per_page)
  {
    return $this->query->reviews_book($this->isbn, $page, $results_per_page);
  }

  function can_purchase($id)
  {
    return $this->query->can_purchase($id, $this->isbn);
  }
  
}

?>