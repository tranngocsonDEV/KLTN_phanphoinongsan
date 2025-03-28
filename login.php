

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="icon" href="../img/logo32.png" type="image/x-icon">
    <title>Đăng nhập</title>
    
    <link rel="stylesheet" href="../css/bootstrap.min.css" />

</head>
<?php 

include("../config/init.php");
include("../php/connect.php");

 
ob_start();
include("../php/thongBao.php");
?>
<body style="background: url('../img/146174.jpg');background-size: cover;background-repeat: no-repeat;">
<script type="text/javascript" src="../js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../js/thongTinMatKhau.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <div id="wrapper">
  
        <form action="../view/logincode.php" method="POST" id="form-login">
            <h1 class="form-heading">Đăng nhập</h1>
            <div class="form-group">
                <input type="text" class="form-input" name="Username" placeholder="Tên đăng nhập">
            </div>
            <div class="form-group">
                <input type="password" name="Password"  class="form-input" placeholder="Mật khẩu">
            </div>
            <input type="submit" value="Đăng nhập" name="submit"  class="form-submit">
        </form>
    </div>
    <script>
        $(document).ready(function () {
        var toastEl = document.getElementById("myToast");
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
        });
    </script>
</body>

</html>