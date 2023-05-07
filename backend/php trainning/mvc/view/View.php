<?php
namespace View;
 class View{
    public static function render($path,$data){
//        extract($data);
        foreach($data as $key => $value){
            $$key = $value;
        }
       require __DIR__ . '/' . $path;
    }
 }