<?php
include("../php/connect.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Nhận trạng thái từ yêu cầu POST

$type = isset($_POST['type']) ? intval($_POST['type']) : "3";
$status = isset($_POST['status']) ? intval($_POST['status']) : "8";

if ($type == '3') { // Phiếu xuất
    $queryPhieuXuat = "SELECT px.MaPhieuXuat, lp.Ten AS TenPhieu, u.Ten AS TenNguoiLapPhieu, px.NgayGiaoHang, px.TongSoLoaiSanPham 
                       FROM tbl_phieuxuat AS px
                       JOIN tbl_a_loaiphieu AS lp ON px.MaLoaiPhieu = lp.MaLoaiPhieu
                       JOIN tbl_a_trangthaiphieuyeucau tt ON tt.MaTrangThaiPhieu = px.MaTrangThaiPhieu
                       JOIN tbl_nhanvienkho_taophieu_xuat nvk ON nvk.MaPhieuXuat = px.MaPhieuXuat
                       JOIN tbl_user u ON u.IDNhanVien = nvk.IDNhanVien
                       WHERE px.MaTrangThaiPhieu = $status";
    $stmt = $conn->prepare($queryPhieuXuat);
    $stmt->execute();

    // Lấy kết quả từ truy vấn
    $result = $stmt->get_result();

    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = $row; // Đưa từng dòng vào mảng kết quả
    }

    // Cấu trúc tiêu đề bảng cho phiếu xuất
    $columns = [
        ["title" => "Mã phiếu xuất", "data" => "MaPhieuXuat"],
        ["title" => "Tên phiếu", "data" => "TenPhieu"],
        ["title" => "Người lập phiếu", "data" => "TenNguoiLapPhieu"],
        ["title" => "Ngày giao hàng", "data" => "NgayGiaoHang"],
        ["title" => "Tổng số loại sản phẩm", "data" => "TongSoLoaiSanPham"]
    ];

    // Trả dữ liệu dạng JSON
    echo json_encode(["data" => $results, "columns" => $columns]);

} elseif ($type == '4') { // Phiếu yêu cầu đổi trả
    $queryDoiTra = "SELECT yc.MaYeuCauDoiTra, yc.MaPhieuXuat, lp.Ten AS TenPhieu, u.Ten AS TenNguoiLapPhieu, yc.NgayLapDoiTra 
                    FROM tbl_yeucaudoitra AS yc
                    JOIN tbl_a_loaiphieu AS lp ON yc.MaLoaiPhieu = lp.MaLoaiPhieu
                    JOIN tbl_a_trangthaiphieuyeucau tt ON tt.MaTrangThaiPhieu = yc.MaTrangThaiPhieu
                    JOIN tbl_user u ON u.IDNhanVien = yc.NguoiLapDoiTra
                    WHERE yc.MaTrangThaiPhieu = $status";

    $stmt = $conn->prepare($queryDoiTra);
    $stmt->execute();
    $result = $stmt->get_result();

    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = $row; // Đưa từng dòng vào mảng kết quả
    }

    // Cấu trúc tiêu đề bảng cho phiếu đổi trả
    $columns = [
        ["title" => "Mã yêu cầu đổi trả", "data" => "MaYeuCauDoiTra"],
        ["title" => "Mã phiếu xuất", "data" => "MaPhieuXuat"],
        ["title" => "Tên phiếu", "data" => "TenPhieu"],
        ["title" => "Người lập đổi trả", "data" => "TenNguoiLapPhieu"],
        ["title" => "Ngày lập đổi trả", "data" => "NgayLapDoiTra"]
    ];

    echo json_encode(["data" => $results, "columns" => $columns]);
}

// Xây dựng dữ liệu trả về
$data = [];
foreach ($results as $row) {
    if ($status == "8") {
        $actionBtn = "<a href='./phanPhoiDonHang_Ship_HienThi.php?MaPhieuXuat=" . $row['MaPhieuXuat'] . "' class='btn btn-primary btn-md h-100 fs-6'>Xem</a>";
    } else {
        $actionBtn = "<button class='btn btn-primary btn-md' onclick=\"window.location='phanPhoiDonHang_Ship.php?MaPhieuXuat=" . $row['MaPhieuXuat'] . "'\"><i class='bi bi-hand-index-thumb-fill'></i></button>";
    }

    $data[] = [
        "MaPhieuXuat" => $row['MaPhieuXuat'],
        "TenPhieu" => $row['TenPhieu'],
        "TenNguoiLapPhieu" => $row['TenNguoiLapPhieu'],
        "NgayGiaoHang" => $row['NgayGiaoHang'],
        "TongSoLoaiSanPham" => $row['TongSoLoaiSanPham'],
        "action" => $actionBtn
    ];
}

// Chuẩn bị phản hồi JSON cho DataTable
$response = [
    "data" => $results, // Kết quả truy vấn
    "columns" => $columns // Cấu trúc cột
];



header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;

?>