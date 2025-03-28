<?php
session_start();
include("../php/connect.php");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $MaPhieuXuatKho = $_POST["MaPhieuXuatKho"];

    // Bắt đầu transaction để đảm bảo tính nhất quán
    $conn->begin_transaction();
    try {
        // Xóa tbl_thanhtoan
        $deleteThanhToan = $conn->prepare("DELETE FROM tbl_thanhtoan WHERE MaPhieuXuat = ?");
        $deleteThanhToan->bind_param("s", $MaPhieuXuatKho);
        if (!$deleteThanhToan->execute()) {
            throw new Exception("Lỗi khi xóa chi tiết thanh toán: " . $deleteChiTiet->error);
        }

        // Xóa các bản ghi chi tiết phiếu xuất
        $deleteChiTiet = $conn->prepare("DELETE FROM tbl_chitietphieuxuat WHERE MaPhieuXuat = ?");
        $deleteChiTiet->bind_param("s", $MaPhieuXuatKho);
        if (!$deleteChiTiet->execute()) {
            throw new Exception("Lỗi khi xóa chi tiết phiếu xuất: " . $deleteChiTiet->error);
        }

        // Xóa phiếu xuất
        $deletePhieu = $conn->prepare("DELETE FROM tbl_phieuxuat WHERE MaPhieuXuat = ?");
        $deletePhieu->bind_param("s", $MaPhieuXuatKho);
        if (!$deletePhieu->execute()) {
            throw new Exception("Lỗi khi xóa phiếu xuất cụ thể: " . $deletePhieu->error);
        }

        // Xóa thông tin nhân viên lập phiếu
        $stmtNhanVien = $conn->prepare("DELETE FROM tbl_nhanvienkho_taophieu_xuat WHERE MaPhieuXuat = ?");
        $stmtNhanVien->bind_param("s", $MaPhieuXuatKho);
        if (!$stmtNhanVien->execute()) {
            throw new Exception("Không thể xóa nhân viên lập phiếu: " . $stmtNhanVien->error);
        }

        // Commit transaction sau khi xóa thành công tất cả các bảng liên quan
        $conn->commit();
        $_SESSION['message'] = "Xóa phiếu xuất thành công!";
        $_SESSION['message_type'] = "success";
        header("Content-Type: application/json");
        echo json_encode(["status" => "success", "message" => "Xóa phiếu xuất thành công!"]);
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['errorMessages'] = "Lỗi khóa ngoại khi xóa!";
        $_SESSION['message_type'] = "error";
        header("Content-Type: application/json");
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    } finally {
        $deleteChiTiet->close();
        $deletePhieu->close();
        $stmtNhanVien->close();
        $conn->close();
    }
}
