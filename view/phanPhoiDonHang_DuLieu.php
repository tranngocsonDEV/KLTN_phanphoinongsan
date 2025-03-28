<?php
include("../php/connect.php");

// Kiểm tra yêu cầu từ DataTable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "
        SELECT s.MaShipper, s.TinhTrang, u.Ten AS TenNhanVien 
        FROM tbl_shipper s
        JOIN tbl_user u ON s.MaShipper = u.IDNhanVien
        WHERE s.TinhTrang = 'Rảnh'
    ";

    $result = mysqli_query($conn, $query);

    $data = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    // Trả về JSON theo định dạng DataTable
    $response = [
        "draw" => intval($_POST['draw'] ?? 1),
        "recordsTotal" => count($data),
        "recordsFiltered" => count($data),
        "data" => $data
    ];

    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
?>