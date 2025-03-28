<?php

ob_start();
include("../config/init.php");

include("../php/thongBao.php");
if (isset($_GET['btn_request_confirm'])) {
    $MaPhieuXuatKho = $_GET['MaPhieuXuatKho'];
    $sql = "UPDATE tbl_phieuxuat SET MaTrangThaiPhieu = 4 WHERE MaPhieuXuat = '$MaPhieuXuatKho'";
    if ($conn->query(query: $sql)) {
        $_SESSION['message'] = "Duyệt thành công!";
        header("Location: phieuYeuCau_Xuat.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Duyệt phiếu không thành công! ";
        header("Location: phieuYeuCau_ChiTietXuat_DuyetPhieu.php?MaPhieuXuatKho='$MaPhieuXuatKho'");
        exit;
    }
}


// Nếu nhấn vào Hủy phiếu
if (isset($_GET['btn_request_deny'])) {
    $MaPhieuXuatKho = $_GET['MaPhieuXuatKho'];

    // Cập nhật trạng thái phiếu thành "Đã hủy" (MaTrangThaiPhieu = 5 hoặc trạng thái khác tùy theo yêu cầu)
    $sql = "UPDATE tbl_phieuxuat SET MaTrangThaiPhieu = 5 WHERE MaPhieuXuat = '$MaPhieuXuatKho'";

    if ($conn->query($sql)) {
        // Cập nhật thành công, chuyển người dùng trở lại trang phieuYeuCau_Xuat.php
        $_SESSION['message'] = "Hủy phiếu thành công!";
        header("Location: phieuYeuCau_Xuat.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Hủy phiếu không thành công!";
        header("Location: phieuYeuCau_ChiTietNhap_DuyetPhieu.php?MaPhieuXuatKho='$MaPhieuXuatKho'");
        exit;
    }
}
ob_end_flush();
?>