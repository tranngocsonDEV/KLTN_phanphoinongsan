<?php
include("../config/init.php");
include("../php/thongBao.php");


if (isset($_POST['xoaSanPham'])) {
    $MaSanPham = $_POST['MaSanPham_text'];
    $IDNhanVien = $_POST['IDNhanVien'];
    $SoLuongTonSanPhamDeThanhLy = $_POST['SoLuongTonSanPham'];
    $ThoiDiemTao = $_POST['ThoiDiemTao'];
    $loaiThanhLy = 'Xóa';
    // Insert data into `tbl_yeucau_thanhly` with status "Chờ duyệt"
    $sql = "INSERT INTO tbl_thanhly (MaThanhLy, MaSanPham, MaNguoiTao, MaTrangThaiPhieu, ThoiGian, SoLuong, LoaiThanhLy, GhiChu)
            VALUES ('', '$MaSanPham', '$IDNhanVien', 17, '$ThoiDiemTao', '$SoLuongTonSanPhamDeThanhLy', '$loaiThanhLy', '')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Đề xuất xóa tổng số lượng sản phẩm đã được gửi thành công và đang chờ duyệt.";
    } else {
        $_SESSION['errorMessages'] = "Đề xuất xóa tổng số lượng sản phẩm không thành công.";
    }

    header("Location: nvQuanLyKho.php");
    exit;
}
?>