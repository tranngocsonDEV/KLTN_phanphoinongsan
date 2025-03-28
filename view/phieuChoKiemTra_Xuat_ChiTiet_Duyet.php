<?php

ob_start();
include("../config/init.php");

include("../php/thongBao.php");
if (isset($_GET['btn_request_confirm'])) {
    $MaPhieuNhapKho = $_GET['MaPhieuNhapKho'];
    // Thực hiện cập nhật trạng thái của phiếu có MaDon tương ứng trong cơ sở dữ liệu
    $sql = "UPDATE tbl_phieuxuat SET MaTrangThaiPhieu = 3 WHERE MaPhieuXuat = '$MaPhieuNhapKho'";
    if ($conn->query(query: $sql)) {
        $_SESSION['message'] = "Phiếu được cập nhật thành công!";
        header("Location: nvkkPhieuChoKiemTra.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Cập nhật không thành công! ";
        header("Location: phieuChoKiemTra__Xuat_ChiTiet_HienThi.php?MaPhieuNhapKho='$MaPhieuNhapKho'");
        exit;
    }
}



ob_end_flush();
?>