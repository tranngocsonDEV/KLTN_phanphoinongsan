<?php

ob_start();
include("../config/init.php");

include("../php/thongBao.php");
if (isset($_GET['btn_request_confirm'])) {
    $conn->begin_transaction();

    try {
        // Kiểm tra dữ liệu GET
        if (!isset($_GET['MaYeuCauDoiTra']) || !isset($_GET['MaPhieuXuat'])) {
            throw new Exception("Dữ liệu không hợp lệ!");
        }

        $MaYeuCauDoiTra = $_GET['MaYeuCauDoiTra'];
        $MaPhieuXuat = $_GET['MaPhieuXuat'];

        // Kiểm tra tính hợp lệ của dữ liệu (VD: tránh SQL Injection)
        if (empty($MaYeuCauDoiTra) || empty($MaPhieuXuat)) {
            throw new Exception("Mã yêu cầu đổi trả hoặc mã phiếu xuất bị trống!");
        }

        // Bắt đầu transaction
        $conn->begin_transaction();

        // Cập nhật trạng thái phiếu đổi trả
        $sql1 = "UPDATE tbl_yeucaudoitra SET MaTrangThaiPhieu = 19 WHERE MaYeuCauDoiTra = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("s", $MaYeuCauDoiTra);
        $stmt1->execute();

        // Cập nhật trạng thái phiếu xuất
        $sql2 = "UPDATE tbl_phieuxuat SET MaTrangThaiPhieu = 21 WHERE MaPhieuXuat = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s", $MaPhieuXuat);
        $stmt2->execute();

        // Kiểm tra kết quả
        if ($stmt1->affected_rows === 0 || $stmt2->affected_rows === 0) {
            throw new Exception("Không có dữ liệu nào được cập nhật!");
        }

        // Commit transaction
        $conn->commit();

        $_SESSION['message'] = "Duyệt phiếu thành công!";
        header("Location: yeuCau_DoiTra.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        $conn->rollback();

        $_SESSION['errorMessages'] = "Lỗi: " . $e->getMessage();
        header("Location: phieuYeuCau_ChiTietDoiTra_DuyetPhieu.php?MaYeuCauDoiTra=$MaYeuCauDoiTra");
        exit;
    }

}


// Nếu nhấn vào Hủy phiếu
if (isset($_GET['btn_request_deny'])) {
    $MaYeuCauDoiTra = $_GET['MaYeuCauDoiTra'];

    $sql = "UPDATE tbl_yeucaudoitra SET MaTrangThaiPhieu = 20 WHERE MaYeuCauDoiTra = '$MaYeuCauDoiTra'";

    if ($conn->query($sql)) {
        // Cập nhật thành công, chuyển người dùng trở lại trang phieuYeuCau_Xuat.php
        $_SESSION['message'] = "Hủy phiếu thành công!";
        header("Location: yeuCau_DoiTra.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Hủy phiếu không thành công!";
        header("Location: phieuYeuCau_ChiTietDoiTra_DuyetPhieu.php?MaYeuCauDoiTra='$MaYeuCauDoiTra'");
        exit;
    }
}
ob_end_flush();
?>