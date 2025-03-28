<?php

ob_start();
include("../config/init.php");

include("../php/thongBao.php");
if (isset($_GET['btn_request_confirm'])) {
    $MaPhieuNhapKho = $_GET['MaPhieuNhapKho'];
    // Thực hiện cập nhật trạng thái của phiếu có MaDon tương ứng trong cơ sở dữ liệu
    $sql = "UPDATE tbl_phieunhap SET MaTrangThaiPhieu = 4 WHERE MaPhieuNhap = '$MaPhieuNhapKho'";
    if ($conn->query(query: $sql)) {
        // Cập nhật thành công, chuyển người dùng trở lại trang phieuNhap.php
        $_SESSION['message'] = "Duyệt thành công!";
        header("Location: phieuYeuCau.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Duyệt phiếu không thành công! ";
        header("Location: phieuYeuCau_ChiTietNhap_DuyetPhieu.php?MaPhieuNhapKho='$MaPhieuNhapKho'");
        exit;
    }
}


// Nếu nhấn vào Hủy phiếu
if (isset($_GET['btn_request_deny'])) {
    $MaPhieuNhapKho = $_GET['MaPhieuNhapKho'];

    // Cập nhật trạng thái phiếu thành "Đã hủy" (MaTrangThaiPhieu = 5 hoặc trạng thái khác tùy theo yêu cầu)
    $sql = "UPDATE tbl_phieunhap SET MaTrangThaiPhieu = 5 WHERE MaPhieuNhap = '$MaPhieuNhapKho'";

    if ($conn->query($sql)) {
        // Cập nhật thành công, chuyển người dùng trở lại trang phieuYeuCau.php
        $_SESSION['message'] = "Hủy phiếu thành công!";
        header("Location: phieuYeuCau.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Hủy phiếu không thành công!";
        header("Location: phieuYeuCau_ChiTietNhap_DuyetPhieu.php?MaPhieuNhapKho='$MaPhieuNhapKho'");
        exit;
    }
}
ob_end_flush();
?>