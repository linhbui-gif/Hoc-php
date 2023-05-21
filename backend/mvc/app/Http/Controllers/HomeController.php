<?php

namespace App\Http\Controllers;

use View\View;
use Models\Product;

class HomeController {

    public function index() 
    {
        $productModel = new Product();
        $products = $productModel->get();
        $message= null;
        if(!empty($_SESSION['message'])){
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        View::render('home/index.php', [
            'productInfor' => $products,
            'message' => $message
        ]);
    }

    public function create() 
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $productModel = new Product();
        if($requestMethod === 'POST') {
            // save database and redirect to list product
            $productModel->insert([
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'description' => $_POST['description']
            ]);
            $_SESSION['message'] = 'Thêm dữ liệu thành công';
            // reirect to proiduct list
            header("Location: /");
        }

        View::render('home/create.php');
    }

    public function edit() 
    {
        echo "edit";
    }

}