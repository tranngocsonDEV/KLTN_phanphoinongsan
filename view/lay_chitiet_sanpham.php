<?php
include("../php/connect"); // Kết nối đến cơsở dữ liệu

if (isset($_POST['maPhieu'])) {
    $maPhieu = $_POST['maPhieu'];
    
    // Truy vấn cơ sở dữ liệu để lấy chi tiết sản phẩm
    $query = "SELECT sp.TenSanPham, ct.SoLuong, ct.DonVi
              FROM tbl_chitietphieuyeucau AS ct
              JOIN tbl_sanpham AS sp ON ct.MaSanPham = sp.MaSanPham
              WHERE ct.MaPhieu = '$maPhieu'";
    $result = mysqli_query($conn, $query);

    $sanPhamData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $sanPhamData[] = $row;
    }

    // Trả về kết quả dưới dạng JSON
    echo json_encode($sanPhamData);
}
?>
