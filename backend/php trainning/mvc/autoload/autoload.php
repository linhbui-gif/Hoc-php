<?php
//Đây là hàm magic của php core khi xảy ra lỗi sẽ chạy vào đây
spl_autoload_register(function ($class) {
    $class =  str_replace("App","app", $class);
    $class =  str_replace("\\","/", $class);
    $classDir = __DIR__ . '/../' . $class . '.php';
    require $classDir;
});
