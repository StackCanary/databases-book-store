<?php

class Query
{

  public $db;

  function Query()
  {
    $this->db  = new Database();
  }

  function book($isbn)
  {
    $stmt = $this->db->get_c()->prepare("SELECT * FROM books where isbn=(?)");
    $stmt->bind_param('s', $isbn);
    $stmt->execute();
    return $stmt->get_result();
  }

  function books($page, $results_per_page)
  {
    $starting_point = $page * $results_per_page;
    $stmt = $this->db->get_c()->prepare("SELECT * FROM books LIMIT ?, ?");
    $stmt->bind_param('ii', $starting_point, $results_per_page);
    $stmt->execute();
    return $stmt->get_result();
  }


  function books_purchased_by($page, $results_per_page, $person_id)
  {
    $starting_point = $page * $results_per_page;
    
    $stmt = $this->db->get_c()->prepare("select * from purchased_by natural join books where customer=(?) LIMIT ?, ?");
    $stmt->bind_param('iii', $person_id, $starting_point, $results_per_page);
    $stmt->execute();

    return $stmt->get_result();
  }

  function author($isbn)
  {
    $stmt = $this->db->get_c()->prepare("select distinct name, author from books natural join authored_by join person on (person_id = author) where isbn=(?)");
    $stmt->bind_param('i', $isbn);
    $stmt->execute();

    return $stmt->get_result();
  }

  function books_by_author($page, $results_per_page, $author)
  {
    $starting_point = $page * $results_per_page;
    
    $stmt = $this->db->get_c()
          ->prepare("SELECT isbn, author FROM books NATURAL JOIN authored_by JOIN person on (authored_by.author = person.person_id) where author=(?) LIMIT ?, ?");
    $stmt->bind_param('iii', $author, $starting_point, $results_per_page);
    $stmt->execute();
    
    return $stmt->get_result();
  }

  function reviews_book($isbn, $page, $results_per_page)
  {
    $starting_point = $page * $results_per_page;
    $stmt = $this->db->get_c()->prepare("select comment, rating from  books natural join purchased_by where isbn=(?) and comment is not null and rating is not null LIMIT ?, ?");
    $stmt->bind_param('sii', $isbn, $starting_point, $results_per_page);

    $stmt->execute();

    return $stmt->get_result();
  }

  function leave_review($id, $isbn, $review, $rating)
  {

    if ($rating < 0 || $rating > 5)
      return false;

    if (empty($review))
      return false;

    $stmt = $this->db->get_c()->prepare("SELECT isbn FROM books WHERE isbn=(?)");
    $stmt->bind_param('s', $isbn);
    $stmt->execute();

    /* Book doesn't exist */
    if ($stmt->get_result()->num_rows == 0)
      return false;

    $stmt = $this->db->get_c()->prepare("UPDATE purchased_by SET comment=(?), rating=(?) where customer=(?) AND isbn=(?)");


    $stmt->bind_param('siis', $review, $rating, $id, $isbn);

    

    $stmt->execute();
  }

  function has_left_review($id, $isbn)
  {
    $stmt = $this->db->get_c()->prepare("SELECT customer, isbn from purchased_by where customer=(?) and isbn=(?)");
    $stmt->bind_param('is', $id, $isbn);
    $stmt->execute();

    return $stmt->get_result()->num_rows == 0;
  }
    
  function books_popular($page, $results_per_page)
  {
    $starting_point = $page * $results_per_page;
    $stmt = $this->db->get_c()->prepare("SELECT *, count(*) as sum FROM purchased_by NATURAL JOIN books GROUP BY isbn ORDER BY sum DESC LIMIT ?, ?");
    $stmt->bind_param('ii', $starting_point, $results_per_page);
    $stmt->execute();

    return $stmt->get_result();
  }

  function purchase($id, $isbn)
  {
    $stmt = $this->db->get_c()->prepare("SELECT isbn FROM books WHERE isbn=(?)");
    $stmt->bind_param('s', $isbn);
    $stmt->execute();

    /* Book doesn't exist */
    if ($stmt->get_result()->num_rows == 0)
      return false;
    
    $stmt = $this->db->get_c()->prepare("INSERT into purchased_by VALUES ( (?), (?), null, null);");
    $stmt->bind_param('is', $id, $isbn);
    $stmt->execute();

    return true;
  }

  function can_purchase($id, $isbn)
  {
    
    $stmt = $this->db->get_c()->prepare("SELECT customer, isbn from purchased_by where customer=(?) and isbn=(?)");
    $stmt->bind_param('is', $id, $isbn);
    $stmt->execute();

    return $stmt->get_result()->num_rows == 0;
  }
  

}

?>