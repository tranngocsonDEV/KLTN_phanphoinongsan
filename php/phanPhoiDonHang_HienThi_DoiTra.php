<?php
include("../php/connect.php");

// Nhận trạng thái từ yêu cầu POST
$status = isset($_POST["status"]) ? $_POST["status"] : "16";  // Mặc định là "16"

// Xây dựng câu truy vấn SQL dựa trên trạng thái
$sql = "SELECT
 yc.MaYeuCauDoiTra, yc.MaPhieuXuat,lp.Ten AS TenPhieu, u.Ten AS TenNguoiLapPhieu, yc.NgayLapDoiTra
                       FROM tbl_yeucaudoitra AS yc
                    	JOIN tbl_a_loaiphieu AS lp ON yc.MaLoaiPhieu = lp.MaLoaiPhieu
                       JOIN tbl_a_trangthaiphieuyeucau tt ON tt.MaTrangThaiPhieu = yc.MaTrangThaiPhieu
                       JOIN tbl_user u ON u.IDNhanVien = yc.NguoiLapDoiTra
                        WHERE yc.MaTrangThaiPhieu = ?";

// Chuẩn bị và thực thi câu truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $status);
$stmt->execute();
$result = $stmt->get_result();

// Xây dựng dữ liệu trả về
$data = [];
while ($row = $result->fetch_assoc()) {
    // Kiểm tra trạng thái để xác định hành động phù hợp
    if ($status == "8") {
        // Nếu là Đã phân phối (status = 8), hiển thị nút "Xem"
        $actionBtn = "<a href='./phanPhoiDonHang_Ship_HienThi_DoiTra.php?MaYeuCauDoiTra=" . $row['MaYeuCauDoiTra'] . "&MaPhieuXuat=" . $row['MaPhieuXuat'] . "' 
        data-maphieuxuat='" . $row['MaPhieuXuat'] . "' 
        class='btn btn-primary btn-md h-100 fs-6'>Xem</a>";

    } else {
        // Nếu là trạng thái khác (ví dụ, Chờ phân phối), hiển thị nút khác (hoặc không hiển thị gì)
        $actionBtn = "<button class='btn btn-primary btn-md' 
        data-maphieuxuat='" . $row['MaPhieuXuat'] . "' 
        onclick=\"window.location='phanPhoiDonHang_Ship_DoiTra.php?MaYeuCauDoiTra=" . $row['MaYeuCauDoiTra'] . "&MaPhieuXuat=" . $row['MaPhieuXuat'] . "'\">
        <i class='bi bi-hand-index-thumb-fill'></i>
    </button>";
    }

    $data[] = [
        "MaYeuCauDoiTra" => $row['MaYeuCauDoiTra'],
        "MaPhieuXuat" => $row['MaPhieuXuat'],
        "TenPhieu" => $row['TenPhieu'],
        "TenNguoiLapPhieu" => $row['TenNguoiLapPhieu'],
        "NgayLapDoiTra" => $row['NgayLapDoiTra'],
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
header( 'Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
?>