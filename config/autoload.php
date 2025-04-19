<?php 
    spl_autoload_register(function ($class) {
         include_once ('/var/www/html/WeLoc/models/' . $class . '.php');
     });
    
    
?>


