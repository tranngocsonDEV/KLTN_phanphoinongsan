<?php
session_start();


include("../php/connect.php");

if (isset($_POST['checking_add'])) {
    $tenSP = $_POST['TenSP'];
    $donVi = $_POST['DonVi'];
    $loaiSP = $_POST['LoaiSP'];


    $query = "INSERT INTO tbl_sanpham 
        (`MaSanPham`, `Ten`, `DonVi`, `GiaBan`, `Loai`, `SoLuongTon`)
        VALUES ('', '$tenSP', '$donVi', '0', '$loaiSP', '0')";

    $result = mysqli_query($conn, $query);

    header('Content-Type: application/json');

    if ($result) {
        $response = array(
            'status' => 'success',
            'message' => 'Sản phẩm được thêm thành công'
        );

    } else {
        $response = array(
            'status' => 'error',
            'message' => "Thêm sản phẩm không thành công: " . $conn->error
        );
        $_SESSION['errorMessages'] = $response['message'];
    }

    echo json_encode($response);
    mysqli_close($conn);
    exit();
}
?>