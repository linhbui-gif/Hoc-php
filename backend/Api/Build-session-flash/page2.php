<?php

session_start();

require __DIR__  . '/inc/flash.php';
require __DIR__ . '/inc/header.php';
$flag = new FlashMessage();
$flag->flash('fail');

require __DIR__ . '/inc/footer.php';