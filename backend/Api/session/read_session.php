<?php

session_start();//Khi có session đó rồi thì browser sẽ ko tạo ra sesion mới, khi có sessionID rồi thì sẽ đọc nó ra. bản chất để start khi giao tiếp giữa client và server
echo "<pre>";
print_r($_SESSION);
// session lưu ở server , cookie lưu ở client

//La