<?php
//Lib validate
$dataForm = [
    'name' =>  '',
    'email' =>  '',
];


$rules = [
    'name' => 'required',
    'email' => 'required|email|min:3|between:3,10|required_with:name',
];
$message = [
   'name.required' => 'Bạn bắt buộc phải nhập tên',
   'email.required' => 'Bạn bắt buộc phải nhập email',
   'email.email' => 'Phải nhập đúng định dạng Email',
   'email.min' => 'Email phải có ít nhất 3 kí tự',
   'email.between' => 'Email phải có  3 đến 10 kí tự',
];
require (__DIR__.'/ValidateService.php');
//init data
$validate = new ValidateService($dataForm,$rules);

//validate
$validate->setMessage($message);
$validate->validate();
//get error
echo "<pre>";
var_dump($validate->getErrors());
