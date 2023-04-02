<?php

spl_autoload_register(function ($class) {
    $class =  str_replace("App","app", $class);
    $class =  str_replace("\\","/", $class);
    $filePath = __DIR__ . "/../" . $class. ".php";
    if(file_exists($filePath)) {
        require $filePath;
    }
});

//routing
$routeInstance =  new \App\Router\Route();

// define route /home
$routeInstance->addRouter('/home',[
    "controller" => "App\Http\Controllers\HomeController",
    "action"     => "index"
]);
$routeInstance->addRouter('/posts',[
    "controller" => "App\Http\Controllers\PostController",
    "action"     => "index"
]);
$pathCurentRequest  = $_SERVER['REQUEST_URI'];
//Dispatch routing -- matching request current with list table routing
$routeInstance->matchRouteExcute($pathCurentRequest);
$routeInstance->getRouteList();