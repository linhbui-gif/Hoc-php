<?php
namespace App\Router;

class Route{
    private $routes = [];
    public function addRoute($path, $routingInfo){
       $this->routes[$path] = $routingInfo;
//       echo "<pre>";
//       print_r($this->routes);
    }
    public function getAllRoute(){

    }
    public function dispatchRouting($pathCurrentRequest){
         foreach ($this->routes as $keyPath => $controllerInfo){
             if($keyPath === $pathCurrentRequest){
                  $controllerName = $controllerInfo['controller'];
                  $action = $controllerInfo['action'];
                  $controller = "\\" . $controllerName;
                  $controllerInstance = new $controller();
                 return $controllerInstance->$action();
             } else {
                 echo "Not Found";
             }

         }
    }
}