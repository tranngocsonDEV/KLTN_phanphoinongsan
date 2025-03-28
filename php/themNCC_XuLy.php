<?php
session_start();
include("../php/thongBao.php");

include("../php/connect.php");

if (isset($_POST['checking_add'])) {
    $tenNCC = $_POST['TenNCC'];
    $diaChi = $_POST['DiaChi'];
    $soDienThoai = $_POST['SoDienThoai'];
    $email = $_POST['Email'];
    $nganhHangCungCap = $_POST['NganhHangCungCap'];
    $sanPhamCungCap = $_POST['SanPhamCungCap'];

    $query = "INSERT INTO tbl_nhacungcap 
        (`MaNhaCungCap`, `Ten`, `DiaChi`, `SoDienThoai`, `Email`, `NganhHangCungCap`, `SanPhamCungCap`)
        VALUES ('', '$tenNCC', '$diaChi', '$soDienThoai', '$email', '$nganhHangCungCap', '$sanPhamCungCap')";

    $result = mysqli_query($conn, $query);

    header('Content-Type: application/json');

    if ($result) {
        $newMaNCC = mysqli_insert_id($conn);
        $response = array(
            'status' => 'success',
            'MaNhaCungCap' => $newMaNCC,
            'message' => 'Thêm nhà cung cấp thành công'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => "Thêm nhà cung cấp không thành công: " . $conn->error
        );
        $_SESSION['errorMessages'] = $response['message'];
    }

    echo json_encode($response);
    mysqli_close($conn);
    exit();
}
?>