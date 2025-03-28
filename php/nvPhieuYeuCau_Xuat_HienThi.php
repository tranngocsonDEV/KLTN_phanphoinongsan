<?php
include("../php/connect.php");

if (isset($_POST['action']) && $_POST['action'] == 'fetchData') {
    $draw = $_POST['draw'];
    $start = $_POST['start'];
    $length = $_POST['length'];
    $status = isset($_POST['status']) ? $_POST['status'] : 4; // Default to "Đã duyệt" (4)

    // Tổng số bản ghi trong bảng
    $totalQuery = "SELECT COUNT(*) as total FROM tbl_phieuxuat";
    $stmt = $conn->prepare($status ? $totalQuery . " WHERE MaTrangThaiPhieu = ?" : $totalQuery);
    if ($status)
        $stmt->bind_param("i", $status);
    $stmt->execute();
    $totalResult = $stmt->get_result();
    $recordsTotal = $totalResult->fetch_assoc()['total'];

    // Lấy dữ liệu với phân trang
    $query = "
SELECT px.MaPhieuXuat AS MaPhieuXuatKho, lp.Ten AS Ten, nvk.IDNhanVien AS IDNhanVienKho, u.Ten AS NhanVienKho,
        NgayLapPhieu, NgayXuatHang, NgayGiaoHang, TongSoLoaiSanPham, GhiChu 
        FROM tbl_phieuxuat AS px
        JOIN tbl_a_trangthaiphieuyeucau AS tt
        ON px.MaTrangThaiPhieu = tt.MaTrangThaiPhieu
        JOIN tbl_a_loaiphieu AS lp 
        ON px.MaLoaiPhieu = lp.MaLoaiPhieu
        JOIN tbl_nhanvienkho_taophieu_xuat AS nvk 
        ON px.MaPhieuXuat = nvk.MaPhieuXuat
        JOIN tbl_user AS u 
        ON nvk.IDNhanVien = u.IDNhanVien
        WHERE px.MaTrangThaiPhieu = ?
        ORDER BY px.MaPhieuXuat ASC LIMIT ?, ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $status, $start, $length);
    $stmt->execute();
    $result = $stmt->get_result();

    // Xử lý dữ liệu
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Đếm số bản ghi sau khi lọc (recordsFiltered)
    $filteredQuery = "SELECT COUNT(*) as total FROM tbl_phieuxuat WHERE MaTrangThaiPhieu = ?";
    $stmt = $conn->prepare($filteredQuery);
    $stmt->bind_param("i", $status);
    $stmt->execute();
    $filteredResult = $stmt->get_result();
    $recordsFiltered = $filteredResult->fetch_assoc()['total'];

    // Trả về JSON cho DataTables
    echo json_encode([
        "draw" => intval($draw),
        "recordsTotal" => intval($recordsTotal),
        "recordsFiltered" => intval($recordsFiltered),
        "data" => $data
    ]);
}
$conn->close();

?>