<?php
include("../php/connect.php");

$type = isset($_POST['type']) ? $_POST['type'] : 2; 
// Kiểm tra loại phiếu
if ($type == 1) {
    $query = "SELECT DISTINCT px.MaPhieuXuat AS MaPhieu,  lp.Ten AS TenPhieu, nvk.IDNhanVien AS IDNhanVienKho, u.Ten AS NguoiLapPhieu, px.NgayLapPhieu,
         TongSoLoaiSanPham
                  FROM tbl_phieuxuat px
                  LEFT JOIN tbl_chitietphieuxuat ctpx ON px.MaPhieuXuat = ctpx.MaPhieuXuat
                    JOIN tbl_a_trangthaiphieuyeucau tt
                        ON px.MaTrangThaiPhieu = tt.MaTrangThaiPhieu
                        JOIN tbl_a_loaiphieu lp 
                        ON px.MaLoaiPhieu = lp.MaLoaiPhieu
                        JOIN tbl_nhanvienkho_taophieu_xuat AS nvk 
                        ON px.MaPhieuXuat = nvk.MaPhieuXuat
                        JOIN tbl_user u 
                        ON nvk.IDNhanVien = u.IDNhanVien
                        WHERE px.MaTrangThaiPhieu = 1
";
} else {
    $query = "SELECT DISTINCT pn.MaPhieuNhap AS MaPhieu,  lp.Ten AS TenPhieu, nvk.IDNhanVien AS IDNhanVienKho, u.Ten AS NguoiLapPhieu, pn.NgayLapPhieu, TongSoLoaiSanPham
                  FROM tbl_phieunhap pn
                  LEFT JOIN tbl_chitietphieunhap ctpn ON pn.MaPhieuNhap = ctpn.MaPhieuNhap
                    JOIN tbl_a_trangthaiphieuyeucau tt
                        ON pn.MaTrangThaiPhieu = tt.MaTrangThaiPhieu
                        JOIN tbl_a_loaiphieu lp 
                        ON pn.MaLoaiPhieu = lp.MaLoaiPhieu
                        JOIN tbl_nhanvienkho_taophieu_nhap AS nvk 
                        ON pn.MaPhieuNhap = nvk.MaPhieuNhap
                        JOIN tbl_user u 
                        ON nvk.IDNhanVien = u.IDNhanVien
                        WHERE pn.MaTrangThaiPhieu = 1 AND pn.MaYeuCauDoiTra IS NULL
                  		";
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