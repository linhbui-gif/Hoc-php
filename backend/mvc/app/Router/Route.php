<?php
namespace App\Router;

class Route {
     protected $routes = [];
     public function addRouter($path, $controllerInfo) {
          $this->routes[$path] = $controllerInfo;
     }
     public function getRouteList () {
     }
     public function matchRouteExcute($pathCurentRequest){
          foreach ($this->routes as $keyPath => $controllerInfor){
              if($keyPath === $pathCurentRequest){
                  //tao instanceController
                  // goi action tuong ung
                  $controller = $controllerInfor['controller'];
                  $action = $controllerInfor['action'];
                  $controller = "\\" . $controller;
                  $controllerInstance = new $controller();
                  //dispatch action
                  return $controllerInstance->$action();

              }
          }
     }
}