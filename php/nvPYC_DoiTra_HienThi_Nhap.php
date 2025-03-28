<?php
include("../php/connect.php");

if (isset($_POST['action']) && $_POST['action'] == 'fetchData') {
    $draw = $_POST['draw'];
    $start = $_POST['start'];
    $length = $_POST['length'];
    $status = isset($_POST['status']) ? $_POST['status'] : 19; // Default to "Đã duyệt" (19)

    // Query total records
    $totalQuery = "SELECT COUNT(*) as total FROM tbl_phieunhap  ";
    $stmt = $conn->prepare($status ? $totalQuery . " WHERE MaYeuCauDoiTra IS NOT NULL AND MaTrangThaiPhieu = ?" : $totalQuery);
    if ($status)
        $stmt->bind_param("i", $status);
    $stmt->execute();
    $totalResult = $stmt->get_result();
    $recordsTotal = $totalResult->fetch_assoc()['total'];

    // Query data with pagination and status
    $query = "
        SELECT pn.MaYeuCauDoiTra, pn.MaPhieuNhap, lp.Ten AS Ten, pn.NgayLapPhieu,
        nvk.IDNhanVien AS IDNhanVienKho, u.Ten AS NhanVienKho, pn.MaTrangThaiPhieu
FROM tbl_phieunhap AS pn
JOIN tbl_a_trangthaiphieuyeucau AS tt
                ON pn.MaTrangThaiPhieu = tt.MaTrangThaiPhieu
        JOIN tbl_a_loaiphieu AS lp 
        ON lp.MaLoaiPhieu = pn.MaLoaiPhieu
        JOIN tbl_nhanvienkho_taophieu_nhap AS nvk
        ON nvk.MaPhieuNhap=pn.MaPhieuNhap
        JOIN tbl_user AS u ON u.IDNhanVien = nvk.IDNhanVien 
        WHERE pn.MaYeuCauDoiTra IS NOT NULL AND pn.MaTrangThaiPhieu = ?
        ORDER BY pn.MaYeuCauDoiTra ASC LIMIT ?, ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $status, $start, $length);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Query records count after filtering
    $filteredQuery = "SELECT COUNT(*) as total FROM tbl_phieunhap AS pn WHERE pn.MaYeuCauDoiTra IS NOT NULL AND MaTrangThaiPhieu = ?";
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