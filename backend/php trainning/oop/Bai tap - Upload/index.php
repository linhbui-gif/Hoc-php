
<?php
require(__DIR__ . './Upload.php');
$file = new Upload($_FILES);
if(isset($_POST['submit'])){
  $file->upload();
  var_dump($file->getError());
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    Chọn file để upload:
    <input type="file" name="fileupload" id="fileUpload">
    <input type="submit" style="display: block" value=" Đăng ảnh" name="submit">
</form>
</body>
</html>