<?php

ob_start();
include("../config/init.php");

include("../php/thongBao.php");
if (isset($_GET['btn_modify_confirm'])) {
    $conn->begin_transaction();

    try {
        $MaThanhLy = $_GET['MaThanhLy'];
        $SoLuongThanhLy = $_GET['SoLuongThanhLy'];
        $MaSanPham = $_GET['MaSanPham'];
        // echo "<pre>";
        // print_r($_GET);
        // echo "</pre>";

        // First query to update the liquidation status
        $sql1 = "UPDATE tbl_thanhly SET MaTrangThaiPhieu = 4 WHERE MaThanhLy = '$MaThanhLy'";
        if (!$conn->query($sql1)) {
            throw new Exception("Không thể cập nhật thông tin thanh lý: " . $conn->error);
        }

        // Second query to update the product stock quantity
        $sql2 = "UPDATE tbl_sanpham SET SoLuongTon = SoLuongTon - '$SoLuongThanhLy' WHERE MaSanPham = '$MaSanPham'";
        if (!$conn->query($sql2)) {
            throw new Exception("Không thể cập nhật thông tin về số lượng sản phẩm: " . $conn->error);
        }


        $conn->commit();
        $_SESSION['message'] = "Yêu cầu thanh lý duyệt thành công!";
        echo "<script>
                window.location.href = 'yeuCau_ThanhLy.php';
                </script>";
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi khi tạo phiếu xuất kho: " . $e->getMessage();
    }
}



// Nếu nhấn vào Hủy yêu cầu thanh lý
if (isset($_GET['btn_modify_deny'])) {
    $MaThanhLy = $_GET['MaThanhLy'];

    // Cập nhật trạng thái yêu cầu thanh lý thành "Đã hủy" (MaTrangThaiPhieu = 5 hoặc trạng thái khác tùy theo yêu cầu)
    $sql = "UPDATE tbl_thanhly SET MaTrangThaiPhieu = 5 WHERE MaThanhLy = '$MaThanhLy'";

    if ($conn->query($sql)) {
        // Cập nhật thành công, chuyển người dùng trở lại trang phieuYeuCau_Xuat.php
        $_SESSION['message'] = "Hủy yêu cầu thanh lý thành công!";
        header("Location: yeuCau_ThanhLy.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Hủy yêu cầu thanh lý không thành công!";
        header("Location: yeuCau_ThanhLy_DuyetPhieu.php?MaThanhLy='$MaThanhLy'");
        exit;
    }
}
ob_end_flush();
?>