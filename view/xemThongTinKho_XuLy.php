<?php
include("../config/init.php");

if (isset($_POST['MaSanPham'])) {
    $MaSanPham = $_POST['MaSanPham'];

    // Lấy thông tin từ phiếu nhập
    $queryNhap = "SELECT pn.NgayNhanHang AS ThoiDiem, 'Nhập kho' AS Loai, ct.SoLuong AS SoLuong, ct.DonGiaNhap AS DonGia, pn.GhiChu AS GhiChu
                  FROM tbl_chitietphieunhap AS ct
                  JOIN tbl_phieunhap AS pn 
                  ON ct.MaPhieuNhap=pn.MaPhieuNhap
                  WHERE pn.MaTrangThaiPhieu = 7 AND MaNhaCungCap IS NOT NULL AND ct.MaSanPham =  '$MaSanPham'";
    // Lấy thông tin từ phiếu nhập trả hàng
    $queryTraHang = " SELECT pn.NgayNhanHang AS ThoiDiem, 'Nhập kho trả hàng' AS Loai, ctbb.SoLuongThucTe AS SoLuong, 0 AS DonGia, bb.LyDo AS GhiChu 
                    FROM tbl_chitietbienban AS ctbb
                    JOIN tbl_bienban AS bb
                    ON bb.MaBienBan=ctbb.MaBienBan
                    JOIN tbl_chitietphieunhap AS ctpn
                    ON ctpn.MaChiTietPhieuNhap=ctbb.MaChiTietPhieuNhap
                    JOIN tbl_phieunhap AS pn
                    ON pn.MaPhieuNhap=ctpn.MaPhieuNhap
                    WHERE ctbb.MaChiTietPhieuXuat IS NULL AND pn.MaTrangThaiPhieu = 7 AND ctbb.MaSanPham = '$MaSanPham'";
    // Lấy thông tin từ phiếu xuất
    $queryXuat = "SELECT px.NgayXuatHang AS ThoiDiem, 'Xuất kho' AS Loai, ct.SoLuong AS SoLuong, ct.DonGiaBan AS DonGia, px.GhiChu AS GhiChu
     FROM tbl_chitietphieuxuat AS ct 
     JOIN tbl_phieuxuat AS px 
     ON ct.MaPhieuXuat=px.MaPhieuXuat WHERE px.MaTrangThaiPhieu IN (4,8,9,11,12,13,16,21,22)
     AND ct.MaSanPham = '$MaSanPham'";

    // Lấy thông tin từ phiếu yêu cầu đổi trả
    $queryDoiTra = "SELECT yc.NgayXuatDoiTra AS ThoiDiem, 'Xuất kho đổi trả' AS Loai, ctdt.SoLuongDoiTra AS SoLuong, 0 AS DonGia, yc.LyDoDoiTra AS GhiChu  FROM tbl_chitietyeucaudoitra AS ctdt
        JOIN tbl_yeucaudoitra AS yc
        ON yc.MaYeuCauDoiTra=ctdt.MaYeuCauDoiTra
        WHERE yc.MaTrangThaiPhieu IN (16,8,9,11,12,13,22,21) AND  ctdt.MaSanPham =  '$MaSanPham'";

    // Lấy thông tin từ phiếu thanh lý
    $queryThanhLy = "SELECT ThoiGian AS ThoiDiem, 'Thanh lý' AS Loai, SoLuong AS SoLuong,0 AS DonGia, GhiChu
                     FROM tbl_thanhly WHERE tbl_thanhly.MaTrangThaiPhieu = 4 AND MaSanPham = '$MaSanPham'";

    // Gộp tất cả kết quả
    $query = "$queryNhap UNION ALL $queryTraHang UNION ALL $queryXuat UNION ALL $queryThanhLy UNION ALL  $queryDoiTra ORDER BY ThoiDiem ASC";
    $result = $conn->query($query);

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    // Trả kết quả dưới dạng JSON
    echo json_encode($rows);
}
?>