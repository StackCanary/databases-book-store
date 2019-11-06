<?php

class Customer
{

  public $id;
  public $name;
  public $email;

  function Customer($id, $name, $email)
  {
    $this->id    = $id;	
    $this->name  = $name;	
    $this->email = $email;	
  }

}


?>
