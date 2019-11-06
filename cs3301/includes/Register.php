<?php

class Register
{

  public $name;
  public $email;
  public $password;
  public $dob;
  public $db;

  function Register($name, $email, $dob, $password)
  {
    $this->name     = $name;
    $this->email    = $email;
    $this->dob      = $dob;
    $this->password = $password;

    $this->db  = new Database();

    if ($this->can_register())
      $this->do_registration();
  }

  function can_register()
  {
    $sql = "select * from customer where email = (?)";

    $stmt = $this->db->get_c()->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    return ($stmt->get_result()->num_rows == 0);
  }

  function do_registration()
  {
    $sql  = "insert into person values (null, (?), (?))";
    $stmt = $this->db->get_c()->prepare($sql);
    $stmt->bind_param('ss', $this->name, $this->dob);

    $stmt->execute();
    
    $id =  $this->db->get_c()->insert_id;

    $sql  = "insert into customer values ((?), (?), (?))";
    $stmt = $this->db->get_c()->prepare($sql);
    $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
    $stmt->bind_param('iss', $id, $this->email, $hashed_password);
        
    $stmt->execute();

    echo "Registration successed, you may now login.";
  }

}

?>