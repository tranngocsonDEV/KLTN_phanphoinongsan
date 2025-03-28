<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include("../php/connect.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['btntaomoiphieuyc']) {
        $MaPhieu = $_POST['MaPhieu'];
        $MaLoaiPhieu = "2";
        $MaTrangThaiPhieu = "1";
        $TenPhieu = "Phiếu nhập kho";
        $NguoiLap = $_POST['NguoiLap'];
        $NoiDung = $_POST['NoiDung'];
        $NgayLapPhieu = $_POST['NgayLapPhieu'];
        $NgayDatHang = $_POST['NgayDatHang'];
        $NgayNhanHang = $_POST['NgayNhanHang'];
        $MaNCC = $data['MaNCC'];
        $TenNCC = $data['TenNCC'];
        $DiaChi = $data['DiaChi'];
        $SoDienThoai = $_POST['SoDienThoai'];
        $Email = $_POST['Email'];
        $NganhHangCungCap = $_POST['NganhHangCungCap'];
        $SanPhamCungCap = $_POST['SanPhamCungCap'];
        $data_masp = $_POST['data-masp'];
        $data_tensp = $_POST['data-tensp'];
        $SoLuong = $_POST['SoLuong'];
        $DonVi = $_POST['DonVi'];
        $DonGia = $_POST['DonGia'];
        $ThanhTien = $_POST['ThanhTien'];
        $TongTien = $_POST['TongTien'];
        $conn->begin_transaction();

        $sql1 = "INSERT INTO tbl_phieunhap 
        ('MaPhieuNhap', 'MaLoaiPhieu', 'MaTrangThaiPhieu', 'MaNhaCungCap', 'NgayLapPhieu', 'NgayDatHang', 'NgayNhanHang', 'TongSoLuongSanPham', 'GhiChu') 
        VALUES 
('', $MaLoaiPhieu, $MaTrangThaiPhieu, $MaNCC, '$NgayLapPhieu', '$NgayDatHang', '$NgayNhanHang', '$TongTien', '$NoiDung')";

        $sql2 = "INSERT INTO tbl_chitietphieunhap ('MaChiTietPhieuNhap', 'MaPhieuNhap', 'MaSanPham', 'SoLuong', 'DonGiaNhap', 'ThanhTien', 'TongTien') 
        VALUES 
('', LAST_INSERT_ID(), '$data_masp', '$SoLuong', '$DonGia', '$ThanhTien', '$TongTien')";
        try {

            $kq1 = $conn->query($sql1); // Thực thi câu lệnh SQL
    
            $kq2 = $conn->query($sql2); // Thực thi câu lệnh SQL thứ 2
    

            if (!$kq1 || !$kq2) {
                $conn->rollBack();
                echo "Đã có lỗi";
            } else {
                $conn->commit();
                echo "Cập nhật thành công";
            }
        } catch (Exception $e) {
            $conn->rollBack();
            echo "Lỗi: " . $e->getMessage();
        }
    }
    ?>
</body>

</html>