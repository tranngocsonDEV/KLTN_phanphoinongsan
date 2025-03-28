<?php
session_start();
include("../php/connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $MaYeuCauDoiTra = $_POST["MaYeuCauDoiTra"];

    // Bắt đầu transaction để đảm bảo tính nhất quán
    $conn->begin_transaction();
    try {
        // Xóa các bản ghi chi tiết phiếu yêu cầu đổi trả
        $deleteChiTiet = $conn->prepare("DELETE FROM tbl_chitietyeucaudoitra WHERE MaYeuCauDoiTra = ?");
        $deleteChiTiet->bind_param("s", $MaYeuCauDoiTra);
        if (!$deleteChiTiet->execute()) {
            throw new Exception("Lỗi khi xóa chi tiết phiếu yêu cầu đổi trả: " . $deleteChiTiet->error);
        }

        // Xóa phiếu yêu cầu đổi trả
        $deletePhieu = $conn->prepare("DELETE FROM tbl_yeucaudoitra WHERE MaYeuCauDoiTra = ?");
        $deletePhieu->bind_param("s", $MaYeuCauDoiTra);
        if (!$deletePhieu->execute()) {
            throw new Exception("Lỗi khi xóa phiếu yêu cầu đổi trả cụ thể: " . $deletePhieu->error);
        }


        $conn->commit();
        $_SESSION['message'] = "Xóa phiếu yêu cầu đổi trả thành công!";
        $_SESSION['message_type'] = "success";
        header("Content-Type: application/json");
        echo json_encode(["status" => "success", "message" => "Xóa phiếu yêu cầu đổi trả thành công!"]);
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
        $conn->close();
    }
}
