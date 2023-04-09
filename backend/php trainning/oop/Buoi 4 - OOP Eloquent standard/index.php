<?php
require __DIR__ . '/Product.php';
$productModel = new Product();
//$productModel->insert([
//    "name" => "san pham 1",
//    "description" => "mo ta 1",
//    "price" => 123123
//]);
//$productModel
//    ->where('id',26)
//    ->update([
//    'name' => 'san 123456654767',
//    'description' => 'description 1231212312321332'
//]);

$data =  $productModel
    ->select('name,description')
    ->join('product_tags',  'products.id = product_tags.product_id')
//    ->groupBy('name')
    ->orderBy('name asc')
//    ->having('name')
    ->where('id',27)
    ->get();
echo "<pre>";
print_r($data);