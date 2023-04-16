<?php
require __DIR__ . '/Product.php';
$productModel = new Product();
//$productModel->comments;
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

//$data =  $productModel
//    ->select('products.id,name,description,name_tag')
//    ->join('product_tags',  'products.id = product_tags.product_id')
////    ->groupBy('name')
////    ->orderBy('name asc')
////    ->having('name')
////    ->where('products_id',27)
//    ->get();
//echo "<pre>";
//print_r($data);

$data = $productModel
    ->select('name')
//    ->whereArray([
//       ['name', '=','san'],
//    ])
    ->with('comments');
//    ->get();
echo "<pre>";
print_r($data);
//Cach 1
//$productModel->name = 'product 1223';
//$productModel->save();

//cach 2
//$productModel->setName('product 122222');
//$productModel->save($productModel);

/**
 * 3 bước để xử lý tối ưu query data ==> eager loading
 * 1, Query bảng chính
 * 2, Dùng loop data để đóng gói vào 1 mảng
 * 3, Chuẩn hóa data
 */