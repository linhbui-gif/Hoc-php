<?php
//session là yếu tố connect giữa client và server
//Cách session hoạt động
//1 tạo file định danh bạn là ai trên server
//2 tạo cookie với tên PHPSESSID
session_start();

//Write data in file
$_SESSION['name'] = 'linh';
//session_save_path() // lấy ra path lưu sesion trên server
//Khi tắt 1 tab thì session vẫn sống , nếu tắt hẳn trình duyệt thì session hết hạn ==> khi mở lên thì sẽ tự động tạo ra 1 sessionId mới ở client
//lafm sao để tắt trình duyệt vẫn giữ được session  ==> xác định thêm thời gian sống bằng cách set cookie mới có thêm 1 khoảng thời gian sống

//Keyword search :
// //php keep session when browser close
// php mutiple login session