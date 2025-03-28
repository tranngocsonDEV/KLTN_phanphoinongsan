<?php
session_start();
include("../php/connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $MaPhieuNhapKho = $_POST["MaPhieuNhapKho"];

    // Bắt đầu transaction để đảm bảo tính nhất quán
    $conn->begin_transaction();
    try {
        // Xóa các bản ghi chi tiết phiếu nhập
        $deleteChiTiet = $conn->prepare("DELETE FROM tbl_chitietphieunhap WHERE MaPhieuNhap = ?");
        $deleteChiTiet->bind_param("s", $MaPhieuNhapKho);
        if (!$deleteChiTiet->execute()) {
            throw new Exception("Lỗi khi xóa chi tiết phiếu nhập: " . $deleteChiTiet->error);
        }

        // Xóa phiếu nhập
        $deletePhieu = $conn->prepare("DELETE FROM tbl_phieunhap WHERE MaPhieuNhap = ?");
        $deletePhieu->bind_param("s", $MaPhieuNhapKho);
        if (!$deletePhieu->execute()) {
            throw new Exception("Lỗi khi xóa phiếu nhập cụ thể: " . $deletePhieu->error);
        }

        // Xóa thông tin nhân viên lập phiếu
        $stmtNhanVien = $conn->prepare("DELETE FROM tbl_nhanvienkho_taophieu_nhap WHERE MaPhieuNhap = ?");
        $stmtNhanVien->bind_param("s", $MaPhieuNhapKho);
        if (!$stmtNhanVien->execute()) {
            throw new Exception("Không thể xóa nhân viên lập phiếu: " . $stmtNhanVien->error);
        }

        // Commit transaction sau khi xóa thành công tất cả các bảng liên quan
        $conn->commit();
        $_SESSION['message'] = "Xóa phiếu nhập thành công!";
        $_SESSION['message_type'] = "success";
        header("Content-Type: application/json");
        echo json_encode(["status" => "success", "message" => "Xóa phiếu nhập thành công!"]);
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
