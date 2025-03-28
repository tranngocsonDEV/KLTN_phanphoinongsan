<?php
include("../php/connect.php");
session_start();

// Lấy dữ liệu từ form
$maPhieuNhap = trim($_POST['MaPhieuNhap']); // Loại bỏ khoảng trắng thừa
$soLuongThucTe = $_POST['SoLuongThucTe'];
$ghiChu = $_POST['GhiChuKiemKe'];
$NgayLapKiemKe = $_POST['NgayLapKiemKe'];
$NguoiLapBienBanKiemKe = $_POST['NguoiLapBienBan'];

// Kiểm tra dữ liệu
if (!$maPhieuNhap || !$soLuongThucTe) {
    $_SESSION['error'] = "Dữ liệu không hợp lệ!";
    header("Location: ../php/nvkkXuLyDonHang_Nhap_HienThi.php?MaPhieuNhap=$maPhieuNhap");
    exit;
}

try {
    // Bắt đầu transaction
    $conn->begin_transaction();

    // Update ghi chú phiếu nhập
    $sql1 = "UPDATE `tbl_phieunhap` SET `GhiChu` = ? WHERE `MaPhieuNhap` = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("ss", $ghiChu, $maPhieuNhap);
    $stmt1->execute();

    // Insert biên bản kiểm kê
    $sql2 = "INSERT INTO `tbl_bienban` (`NgayLapBienBan`, `LyDo`, `NguoiLapBienBan`, `TinhTrangChatLuong`) VALUES (?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);
    $TinhTrangChatLuong = 'KhongDat';
    $stmt2->bind_param("ssss", $NgayLapKiemKe, $ghiChu, $NguoiLapBienBanKiemKe, $TinhTrangChatLuong);
    $stmt2->execute();

    // Lấy MaBienBan mới tạo
    $MaBienBan = $conn->insert_id;

    // Chuẩn bị câu lệnh insert vào tbl_chitietbienban
    $sql3 = "INSERT INTO tbl_chitietbienban 
             (MaChiTietBienBan, MaChiTietPhieuXuat, MaChiTietPhieuNhap, MaBienBan, MaSanPham, SoLuongTheoYeuCau, SoLuongThucTe) 
             VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt3 = $conn->prepare($sql3);

    // Duyệt qua các sản phẩm và thực hiện insert
    foreach ($_POST['SoLuongThucTe'] as $productId => $SoLuongThucTeValue) {
        $MaChiTietBienBan = NULL;
        $SoLuongTheoYeuCau = $_POST['SoLuongTheoYeuCau'][$productId];
        $MaChiTietPhieuNhap = $_POST['MaChiTietPhieuNhap'][$productId];
        $MaChiTietPhieuXuat = NULL; // Không có giá trị

        // Kiểm tra số lượng thực tế
        if ($SoLuongThucTeValue > $SoLuongTheoYeuCau) {
            $_SESSION['errorMessages'] = "Số lượng thực tế của sản phẩm $productId lớn hơn số lượng yêu cầu là $SoLuongTheoYeuCau.";
            throw new Exception($_SESSION['errorMessages']);
        }

        // Thêm chi tiết biên bản
        $stmt3->bind_param("iisiiid", $MaChiTietBienBan, $MaChiTietPhieuXuat, $MaChiTietPhieuNhap, $MaBienBan, $productId, $SoLuongTheoYeuCau, $SoLuongThucTeValue);
        $stmt3->execute();

        // Update chi tiết phiếu nhập
        $sqlUpdateChiTiet = "UPDATE tbl_chitietphieunhap 
                             SET SoLuong = ? 
                             WHERE MaPhieuNhap = ? AND MaSanPham = ?";
        $stmtUpdateChiTiet = $conn->prepare($sqlUpdateChiTiet);
        $stmtUpdateChiTiet->bind_param("isi", $SoLuongTheoYeuCau, $maPhieuNhap, $productId);
        $stmtUpdateChiTiet->execute();
    }

    // Cập nhật trạng thái phiếu nhập
    $sqlUpdatePhieu = "UPDATE tbl_phieunhap SET MaTrangThaiPhieu = '3' WHERE MaPhieuNhap = ?";
    $stmtPhieu = $conn->prepare($sqlUpdatePhieu);
    $stmtPhieu->bind_param("s", $maPhieuNhap);
    $stmtPhieu->execute();

    // Commit transaction
    $conn->commit();

    // Thông báo thành công
    $_SESSION['message'] = "Kiểm kê phiếu nhập thành công!";
    header("Location: ../view/nvkkXuLyDonHang.php");
    exit;
} catch (Exception $e) {
    // Rollback transaction nếu có lỗi
    $conn->rollback();
    $_SESSION['error'] = "Lỗi xảy ra: " . $e->getMessage();
    header("Location: ../php/nvkkXuLyDonHang_Nhap_HienThi.php?MaPhieuNhap=$maPhieuNhap");
    exit;
}
?>
