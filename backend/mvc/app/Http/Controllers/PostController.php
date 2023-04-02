<?php
namespace App\Http\Controllers;
use App\View\View;
class PostController {
    public function index(){
        $data['post'] = [
            "name" => "Linh Bui",
            "age" => 25
        ];
       return View::render("post/index.php", $data);
    }
}