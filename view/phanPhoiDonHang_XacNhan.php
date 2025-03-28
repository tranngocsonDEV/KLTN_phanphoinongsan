<?php


include("../php/connect.php");
session_start();

ob_start();

if (isset($_POST['checking_ranh_btn'])) {
    $M_id = $_POST['MaNhanVien_Ranh'];
    $MaPhieu = $_POST['MaPhieuYC'];

    // Khởi tạo một mảng để lưu kết quả
    $result_array = [];

    $query = "SELECT * FROM `tbl_shipper` WHERE MaShipper='$M_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        // Nếu tìm thấy shipper
        $row = mysqli_fetch_assoc($query_run);
        $result_array['success'] = true;
        $result_array['MaPhieu'] = $MaPhieu;
        $result_array['MaShipper'] = $row['MaShipper'];  // Lấy MaShipper từ DB
    } else {
        $result_array['success'] = false;
        $result_array['message'] = "Không tìm thấy dữ liệu!";
    }

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($result_array);
}

// Phân phối đơn hàng
if (isset($_POST['xacNhanPhanPhoi'])) {
    header("Content-Type: application/json; charset=UTF-8"); // Đảm bảo dữ liệu trả về là JSON

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
        // 

        $sql3 = "UPDATE tbl_chitietphieuxuat ctpx SET  ctpx.MaShipper = '$MaNhanVien'  WHERE ctpx.MaPhieuXuat='$MaPhieu'";
        if (!mysqli_query($conn, $sql3)) {
            throw new Exception("Lỗi khi thực hiện cập nhật phiếu xuất với nhân viên kho" . mysqli_error($conn));
        }
        $conn->commit();
        $_SESSION['message'] = "Phân phối đơn hàng thành công!";
        // Trả về JSON thành công với URL chuyển hướng
        echo json_encode([
            "status" => "success",
            "redirect" => "phanPhoiDonHang.php"
        ]);
        exit;


    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['errorMessages'] = "Có lỗi xảy ra khi phân phối!";
        echo json_encode([
            "status" => "error",
            "redirect" => "phanPhoiDonHang.php"
        ]);
        exit;
    }

}


mysqli_close($conn);
ob_end_flush();
?>