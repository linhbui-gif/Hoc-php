<?php

session_start();

require __DIR__ . '/inc/flash.php';
require __DIR__ . '/inc/header.php';

$flag = new FlashMessage();
$flag->create_flash_message('fail', 'Create fail', 'error');
echo '<a href="page2.php" title="Go To Page 2">Go To Page 2</a>';

require __DIR__ . '/inc/footer.php';