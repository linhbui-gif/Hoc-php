<?php
namespace App\Http\Controllers;
use App\View\View;

class HomeController {
    public function index() {
        return View::render("home/home.php");
    }
}
