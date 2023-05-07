<?php
//1, Require file autoload
require __DIR__ . '/autoload/autoload.php';

//2, Routing ( Định tuyến Controller, action, dựa vào routing build in )
$routeInstance = new \App\Router\Route();
require __DIR__ . '/app/Router/web.php';

//Dispatch route
$routeInstance->dispatchRouting($_SERVER['REQUEST_URI']);