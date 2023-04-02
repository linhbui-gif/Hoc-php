<?php
namespace App\View;

class View{
    public static function render($filePath, $data){
        extract($data);
        $filePathInclude = __DIR__ . "/" . $filePath;
        require $filePathInclude;
    }
 }