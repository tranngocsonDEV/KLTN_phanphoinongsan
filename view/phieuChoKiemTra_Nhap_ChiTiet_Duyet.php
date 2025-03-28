<?php

ob_start();
include("../config/init.php");

include("../php/thongBao.php");
if (isset($_GET['btn_request_confirm'])) {
    $MaPhieuNhapKho = $_GET['MaPhieuNhapKho'];
    // Thực hiện cập nhật trạng thái của phiếu có MaDon tương ứng trong cơ sở dữ liệu
    $sql = "UPDATE tbl_phieunhap SET MaTrangThaiPhieu = 3 WHERE MaPhieuNhap = '$MaPhieuNhapKho'";
    if ($conn->query(query: $sql)) {
        // Cập nhật thành công, chuyển người dùng trở lại trang phieuNhap.php
        $_SESSION['message'] = "Phiếu được cập nhật thành công!";
        header("Location: nvkkPhieuChoKiemTra.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Cập nhật không thành công! ";
        header("Location: phieuChoKiemTra__Nhap_ChiTiet_HienThi.php?MaPhieuNhapKho='$MaPhieuNhapKho'");
        exit;
    }
}


ob_end_flush();
?>