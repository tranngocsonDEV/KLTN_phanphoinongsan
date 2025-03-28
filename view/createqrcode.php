<?php
// Đường dẫn đến thư viện PHP QR code
require "../php/connect.php";
require "../phpqrcode/qrlib.php";
session_start();
ob_start();
// Lấy dữ liệu từ biểu mẫu
$tensanpham = isset($_POST['tensanpham']) ? $_POST['tensanpham'] : '';
$MaBaiViet = isset($_POST['productData']) ? $_POST['productData'] : '';

$URL = isset($_POST['linksanpham']) ? $_POST['linksanpham'] : '';

// Kiểm tra xem có dữ liệu từ biểu mẫu không
if (empty($tensanpham) || empty($URL)) {
    $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
    header("Location: nvTaoMaQRCode.php");
    exit; // Dừng thực thi nếu không có dữ liệu
}

// Tạo chuỗi dữ liệu từ thông tin của biểu mẫu
$data = "$URL";

// Đường dẫn và tên file cho mã QR code được tạo
$ngayhientai = date("mdY"); // Định dạng ngày tháng năm
$path = "../qr_images/";
$filename = $path . $tensanpham . "_" . $ngayhientai . ".png";

// Tham số tùy chọn
$ecc = 'H'; // Mức độ sửa lỗi cao
$pixel_size = 6; // Kích thước mỗi điểm ảnh
$frame_size = 2; // Kích thước viền



// Tạo mã QR code
QRcode::png($data, $filename, $ecc, $pixel_size, $frame_size);

// Đọc nội dung tệp ảnh
$imageData = file_get_contents($filename);

// Chuyển đổi ảnh sang Base64
$base64Image = base64_encode($imageData);

// Lưu Base64 vào session
$_SESSION['qrcode_base64'] = $base64Image;

// Kiểm tra xem tệp đã được tạo thành công chưa
if (file_exists($filename)) {
    $sql = "UPDATE tbl_baivietcuasanpham SET QR_IMG = '$filename' WHERE MaBaiViet = '$MaBaiViet'";
    mysqli_query($conn, $sql);


    $_SESSION['message'] = "Tạo mã QR thành công";
    header("Location: nvTaoMaQRCode.php");
    exit;
} else {
    $_SESSION['errorMessages'] = "Đã xảy ra lỗi khi tạo mã QR code.";
    header("location: nvTaoMaQRCode.php");
    exit();
}
?>