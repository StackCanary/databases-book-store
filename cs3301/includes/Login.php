<?php

class Login
{

  function on_not_logged_in()
  {

    if (!$this->is_logged_in())
      header('Location: login.php');

  }

  public $db;
  public $email;
  public $password;

  function Login($email, $password)
  {
    $this->db  = new Database();
    $this->email = $email;
    $this->password = $password;

  }

  function do_login() {

   
      $stmt = $this->db->get_c()->prepare("SELECT * FROM customer natural join person WHERE email=(?)");
      $stmt->bind_param('s', $this->email);

      $stmt->execute();

      $result = $stmt->get_result();

      if ($result->num_rows == 1) {

        $a = $result->fetch_assoc();

        if (password_verify($this->password, $a['password'])) {
          $_SESSION['person_id'] = $a['person_id'];
          $_SESSION['name'] = $a['name'];
          $_SESSION['email'] = $a['email'];
        }

      }
   
  }

  function is_logged_in()
  {
    return isset($_SESSION['person_id']);
  }

  function get_customer()
  {
    return $_SESSION['person_id'];
  }

  function redirect($location)
  {
    header('location: ' . $location);
  }

  function if_login_needed()
  {
    if (!Login::is_logged_in())
      Login::redirect('login.php');
  }

  function if_already_logged_in()
  {
    if(Login::is_logged_in())
      Login::redirect('index.php');
  }

  function logout()
  {
    unset($_SESSION['person_id']);

    Login::if_login_needed();
  }

  
}
?>


  