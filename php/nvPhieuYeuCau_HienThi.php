<?php
include("../php/connect.php");

if (isset($_POST['action']) && $_POST['action'] == 'fetchData') {
    $draw = $_POST['draw'];
    $start = $_POST['start'];
    $length = $_POST['length'];
    $status = isset($_POST['status']) ? $_POST['status'] : 4; // Default to "Đã duyệt" (4)

    // Query total records
    $totalQuery = "SELECT COUNT(*) as total FROM tbl_phieunhap";
    $stmt = $conn->prepare($status ? $totalQuery . " WHERE tbl_phieunhap.MaYeuCauDoiTra IS NULL AND MaTrangThaiPhieu = ?" : $totalQuery);
    if ($status)
        $stmt->bind_param("i", $status);
    $stmt->execute();
    $totalResult = $stmt->get_result();
    $recordsTotal = $totalResult->fetch_assoc()['total'];

    // Query data with pagination and status
    $query = "
        SELECT tbl_phieunhap.MaPhieuNhap AS MaPhieuNhapKho, lp.Ten AS Ten, nvk.IDNhanVien AS IDNhanVienKho,  u.Ten AS NhanVienKho,
               NgayLapPhieu, NgayDatHang, NgayNhanHang, TongSoLoaiSanPham 
        FROM tbl_phieunhap 
        JOIN tbl_a_trangthaiphieuyeucau 
        ON tbl_phieunhap.MaTrangThaiPhieu = tbl_a_trangthaiphieuyeucau.MaTrangThaiPhieu
        JOIN tbl_a_loaiphieu AS lp 
        ON tbl_phieunhap.MaLoaiPhieu = lp.MaLoaiPhieu
        JOIN tbl_nhanvienkho_taophieu_nhap AS nvk 
        ON tbl_phieunhap.MaPhieuNhap = nvk.MaPhieuNhap
        JOIN tbl_user AS u 
        ON nvk.IDNhanVien = u.IDNhanVien
        WHERE tbl_phieunhap.MaTrangThaiPhieu = ? AND tbl_phieunhap.MaYeuCauDoiTra IS NULL
        ORDER BY tbl_phieunhap.MaPhieuNhap ASC LIMIT ?, ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $status, $start, $length);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Query records count after filtering
    $filteredQuery = "SELECT COUNT(*) as total FROM tbl_phieunhap WHERE tbl_phieunhap.MaYeuCauDoiTra IS NULL AND MaTrangThaiPhieu = ?";
    $stmt = $conn->prepare($filteredQuery);
    $stmt->bind_param("i", $status);
    $stmt->execute();
    $filteredResult = $stmt->get_result();
    $recordsFiltered = $filteredResult->fetch_assoc()['total'];

    echo json_encode([
        "draw" => intval($draw),
        "recordsTotal" => intval($recordsTotal),
        "recordsFiltered" => intval($recordsFiltered),
        "data" => $data
    ]);
}

$conn->close();

?>