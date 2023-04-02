<?php
//Lib validate
$dataForm = [
    'name' =>  '',
    'email' =>  '',
    'first_name' =>  '',
];

$rules = [
    'name' => 'required',
    'email' => 'required|email',
    'first_name' => 'required|min:6',
];
require (__DIR__.'/ValidateService.php');
//init data
$validate = new ValidateService($dataForm,$rules);

//validate
$validate->validate();
//get error
echo "<pre>";
var_dump($validate->getErrors());
//if($validate->countErrors()){
//    //show error
//    $errors = $validate->getErrors();
//    echo "<pre/>";
//    print_r($errors);
//} else {
//    //submit form
//    echo 'submit form';
//}
//
