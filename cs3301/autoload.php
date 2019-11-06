<?php
spl_autoload_register(
    function ($class_name) {
      include_once('includes/' . $class_name . '.php');
    });
?>