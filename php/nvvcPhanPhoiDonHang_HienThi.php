<?php
include("../php/connect.php");

// Nhận trạng thái từ yêu cầu POST
$status = isset($_POST["status"]) ? $_POST["status"] : "8";  // Mặc định là "8"
$maShipperDangNhap = $_POST['MaShipperDangNhap'];


// Xây dựng câu truy vấn SQL dựa trên trạng thái
$sql = "SELECT DISTINCT px.MaPhieuXuat, lp.Ten AS TenPhieu, u.Ten AS TenNguoiLapPhieu, px.NgayGiaoHang, px.TongSoLoaiSanPham 
    FROM tbl_phieuxuat AS px
    JOIN tbl_chitietphieuxuat AS ct 
    ON ct.MaPhieuXuat = px.MaPhieuXuat
    JOIN tbl_a_loaiphieu AS lp ON px.MaLoaiPhieu = lp.MaLoaiPhieu
    JOIN tbl_a_trangthaiphieuyeucau tt ON tt.MaTrangThaiPhieu = px.MaTrangThaiPhieu
    JOIN tbl_nhanvienkho_taophieu_xuat nvk ON nvk.MaPhieuXuat = px.MaPhieuXuat
    JOIN tbl_user u ON u.IDNhanVien = nvk.IDNhanVien
    WHERE px.MaTrangThaiPhieu =  ? AND ct.MaShipper =  ?";

// Chuẩn bị và thực thi câu truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $status, $maShipperDangNhap);
$stmt->execute();
$result = $stmt->get_result();



// Xây dựng dữ liệu trả về
$data = [];
while ($row = $result->fetch_assoc()) {
    // Kiểm tra trạng thái để xác định hành động phù hợp
    if ($status == "8") {
        // Nếu là Đã phân phối (status = 8), hiển thị nút "Xem"
        $actionBtn = "<a href='./nvvcPhanPhoiDonHang_Ship_HienThi.php?MaPhieuXuat=" . $row['MaPhieuXuat'] . "' class='btn btn-primary btn-md h-100 fs-6'>Xem</a>";
    } else {
        // Nếu là trạng thái khác (ví dụ, Chờ phân phối), hiển thị nút khác (hoặc không hiển thị gì)
        $actionBtn = "<button class='btn btn-primary btn-md' onclick=\"window.location='nvvcPhanPhoiDonHang_Ship_HienThi_HoanThanh.php?MaPhieuXuat=" . $row['MaPhieuXuat'] . "'\">Xem</button>";
    }

    $data[] = [
        "MaPhieuXuat" => $row['MaPhieuXuat'],
        "TenPhieu" => $row['TenPhieu'],
        "TenNguoiLapPhieu" => $row['TenNguoiLapPhieu'],
        "NgayGiaoHang" => $row['NgayGiaoHang'],
        "TongSoLoaiSanPham" => $row['TongSoLoaiSanPham'],
        "action" => $actionBtn  // Thêm nút hành động vào dữ liệu trả về
    ];
}

// Chuẩn bị phản hồi JSON cho DataTable
$response = [
    "draw" => intval($_POST['draw'] ?? 1),
    "recordsTotal" => $result->num_rows,
    "recordsFiltered" => $result->num_rows,
    "data" => $data
];

// Trả về dữ liệu JSON
header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
?>