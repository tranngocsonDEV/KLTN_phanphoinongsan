<?php
session_start();
include("../php/thongBao.php");
include("../php/connect.php");

if (isset($_POST['checking_add'])) {
    $TenKH = $_POST['TenKH'];
    $diaChi = $_POST['DiaChi'];
    $soDienThoai = $_POST['SoDienThoai'];
    $email = $_POST['Email'];
    $nganhNgheKinhDoanh = $_POST['NganhNgheKinhDoanh'];

    $query = "INSERT INTO tbl_khachhang 
        (`MaKhachHang`, `Ten`, `DiaChi`, `SoDienThoai`, `Email`, `NganhNgheKinhDoanh`)
        VALUES ('', '$TenKH', '$diaChi', '$soDienThoai', '$email', '$nganhNgheKinhDoanh')";

    $result = mysqli_query($conn, $query);

    header('Content-Type: application/json');

    if ($result) {
        $newMaKH = mysqli_insert_id($conn);
        $response = array(
            'status' => 'success',
            'MaKhachHang' => $newMaKH,
            'message' => 'Thêm khách hàng thành công'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => "Thêm khách hàng không thành công: " . $conn->error
        );
        $_SESSION['errorMessages'] = $response['message'];
    }

    echo json_encode($response);
    mysqli_close($conn);
    exit();
}
?>