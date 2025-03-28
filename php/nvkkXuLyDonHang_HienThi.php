<?php
include("../php/connect.php");

$type = isset($_POST['type']) ? $_POST['type'] : 22;

if ($type == 22) {
    $query = "SELECT  MaYeuCauDoiTra, tbl_phieunhap.MaPhieuNhap, nvk.IDNhanVien AS MaNhanVienTaoPhieu, u.Ten AS TenNhanVienTaoPhieu, NgayLapPhieu AS NgayLapBienBan, GhiChu
            FROM tbl_phieunhap 
            JOIN tbl_nhanvienkho_taophieu_nhap AS nvk
            ON nvk.MaPhieuNhap = tbl_phieunhap.MaPhieuNhap
            JOIN tbl_user AS u
            ON u.IDNhanVien = nvk.IDNhanVien
            WHERE MaYeuCauDoiTra IS NOT NULL AND MaTrangThaiPhieu = 1";
} else {
    $query = "SELECT DISTINCT MaYeuCauDoiTra, tbl_phieunhap.MaPhieuNhap, nvk.IDNhanVien AS MaNhanVienTaoPhieu, u.Ten AS TenNhanVienTaoPhieu, NgayLapPhieu, GhiChu, bb.MaBienBan, tbl_phieunhap.NgayLapPhieu AS NgayLapBienBan
            FROM tbl_phieunhap 
            JOIN tbl_nhanvienkho_taophieu_nhap AS nvk
            ON nvk.MaPhieuNhap = tbl_phieunhap.MaPhieuNhap
            JOIN tbl_user AS u
            ON u.IDNhanVien = nvk.IDNhanVien
            JOIN tbl_chitietphieunhap AS ctpn
            ON ctpn.MaPhieuNhap=tbl_phieunhap.MaPhieuNhap
            JOIN tbl_chitietbienban AS ctbb
            ON ctbb.MaChiTietPhieuNhap = ctpn.MaChiTietPhieuNhap
            JOIN tbl_bienban AS bb
            ON bb.MaBienBan=ctbb.MaBienBan
            WHERE MaYeuCauDoiTra IS NOT NULL AND MaTrangThaiPhieu = 3";
}

// Thực thi truy vấn
$result = mysqli_query($conn, $query);
$requests = [];

while ($row = mysqli_fetch_assoc($result)) {
    $row['Type'] = $type; // Hoặc lấy thông tin Type từ cơ sở dữ liệu nếu có

    $requests[] = $row;
}

// Trả về dữ liệu JSON
echo json_encode($requests);
?>