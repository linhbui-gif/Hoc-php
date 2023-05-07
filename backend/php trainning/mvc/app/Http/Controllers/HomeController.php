<?php
namespace App\Http\Controllers;
use view\View;

class HomeController {
    public function index() {
        $data = [
             "name" => "Lindsfsh"
            ];
        View::render('Home/index.php',$data);
    }
}