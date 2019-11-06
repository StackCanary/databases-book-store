<?php
spl_autoload_register(
    function ($class_name) {
        include 'include/' . $class_name . '.php';
    });
?>