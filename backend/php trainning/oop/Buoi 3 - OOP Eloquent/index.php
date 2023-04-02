<?php

require(__DIR__ . './Product.php');
$productModel = new Product();
$productModel->create([
    "name" => "san pham 1",
    "description" => "description 1",
    "price" => "price 1",
]);
