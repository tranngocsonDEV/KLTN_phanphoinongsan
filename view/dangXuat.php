<?php
session_start();
if (isset($_POST['logout_btn'])) {
    unset($_SESSION["auth"]);
    unset($_SESSION["MaVaiTro"]);
    unset($_SESSION["ThongTinDangNhap"]);


    // Hủy toàn bộ session để đảm bảo sạch dữ liệu
    session_destroy();

    header("Location: homePage.php");
    exit();

}
?>