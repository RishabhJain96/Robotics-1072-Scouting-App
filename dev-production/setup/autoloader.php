<?php
//session_start();
// autoloader code
// loads classes as needed, eliminates the need for a long list of includes at the top
spl_autoload_register(function ($className) { 
    $possibilities = array( 
        '../controllers'.DIRECTORY_SEPARATOR.$className.'.php', 
        '../back_end'.DIRECTORY_SEPARATOR.$className.'.php', 
        '../views'.DIRECTORY_SEPARATOR.$className.'.php', 
        $className.'.php' 
    ); 
    foreach ($possibilities as $file) { 
        if (file_exists($file)) {
            require_once($file); 
            return true; 
        } 
    } 
    return false; 
});
?>