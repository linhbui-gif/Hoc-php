<?php 

spl_autoload_register(function ($class) {
    $classDir = str_replace("\\", "/", __DIR__ . "/../" . $class . ".php");  
    require $classDir;
}); 