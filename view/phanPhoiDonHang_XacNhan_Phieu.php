<?php
ob_start();

include("../php/connect.php");
header("Content-Type: application/json; charset=UTF-8"); // Đảm bảo dữ liệu trả về là JSON

// Phân phối đơn hàng
if (isset($_POST['xacNhanPhanPhoi'])) {

    $conn->begin_transaction();
    $MaNhanVien = $_POST['mashipperInput'];
    $MaPhieu = $_POST['maphieuInput'];

    try {
        $sql1 = "UPDATE tbl_shipper SET TinhTrang = 'Không rảnh' WHERE MaShipper = '$MaNhanVien'";

        if (!mysqli_query($conn, $sql1)) {
            throw new Exception("Lỗi khi thực hiện cập nhật trạng thái nhân viên giao hàng" . mysqli_error($conn));
        }
        $sql2 = "UPDATE tbl_phieuxuat px SET  px.MaTrangThaiPhieu ='8'  WHERE px.MaPhieuXuat='$MaPhieu'";
        if (!mysqli_query($conn, $sql2)) {
            throw new Exception("Lỗi khi thực hiện cập nhật phiếu xuất" . mysqli_error($conn));
        }
        $conn->commit();


        $_SESSION['message'] = "Phân phối thành công!";
        exit;


    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['errorMessages'] = "Có lỗi xảy ra khi phân phối!";

        exit;

    }

}


mysqli_close($conn);
ob_end_flush();
?>