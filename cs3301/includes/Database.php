<?php

class Database
{

  public $c;

  function Database()
  {
    $h = 'saaz.host.cs.st-andrews.ac.uk';
    $u = 'saaz';
    $p = '***REMOVED***';
    $d = 'saaz_cs3101_db';
    $this->c = new mysqli($h, $u, $p, $d);
  }

  public function get_c()
  {
    return $this->c;
  }
  
  public function __destruct()
  {
    $this->c->close();
  }

    
}

?>
