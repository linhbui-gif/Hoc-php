<?php
require __DIR__ . '/Category.php';
require __DIR__ . '/Product.php';
require __DIR__ . '/HasOneToMany.php';
require __DIR__ . '/NormalizeData.php';
require __DIR__ . '/Brand.php';
$categoryModel = new Category();
$data = $categoryModel
    ->select('categories.id,name')
    ->with(['products','brands'])
    ->get();

//$data = $categoryModel
//    ->oneToMany();
echo "<pre>";
print_r($data);

/**
 * 3 bước để xử lý tối ưu query data ==> eager loading
 * 1, Query bảng chính
 * 2, Dùng loop data để đóng gói id khóa chính vào 1 mảng
 * 3, Chuẩn hóa data
 */