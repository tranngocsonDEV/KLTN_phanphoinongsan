<?php
include("../php/connect.php");
include("../config/init.php");
include("../php/thongBao.php");

if (isset($_POST['btn_update_article'])) {
    $MaBaiViet = $_POST['MaBaiViet'];
    $TieuDe = $_POST['TieuDe'];
    $NoiDung = $_POST['NoiDung'];
    $NguonGoc = $_POST['NguonGoc'];
    $HinhAnh = ""; // Biến để lưu tên file ảnh mới

    // Kiểm tra nếu có file ảnh mới
    if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] == UPLOAD_ERR_OK) {
        // Đặt thư mục lưu ảnh vào img/
        $targetDir = "../img/";

        // Tạo đường dẫn đầy đủ cho file ảnh
        $targetFile = $targetDir . basename($_FILES["HinhAnh"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kiểm tra loại file hợp lệ (chỉ chấp nhận jpg, jpeg, png, gif)
        if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            // Kiểm tra nếu ảnh đã tồn tại, có thể thay đổi để tránh ghi đè
            if (move_uploaded_file($_FILES["HinhAnh"]["tmp_name"], $targetFile)) {
                // Lưu tên ảnh vào biến HinhAnh
                $HinhAnh = basename($_FILES["HinhAnh"]["name"]);
            } else {
                echo "Lỗi khi tải lên file.";
                exit;
            }
        } else {
            echo "Chỉ chấp nhận các định dạng JPG, JPEG, PNG & GIF.";
            exit;
        }
    } else {
        // Nếu không có file mới, dùng hình ảnh cũ từ $_POST
        $HinhAnh = $_POST['HinhAnhCu']; // Nếu không tải lên file mới, dùng hình ảnh cũ
    }

    // Cập nhật bài viết trong CSDL
    $sql = "UPDATE tbl_baivietcuasanpham 
            SET TieuDe = '$TieuDe', NoiDung = '$NoiDung', HinhAnh = '$HinhAnh', NguonGoc = '$NguonGoc' 
            WHERE MaBaiViet = '$MaBaiViet'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Cập nhật thông tin bài viết thành công!";
        header("Location: ../view/nvBaiVietTruyXuatNG.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Lỗi khi cập nhật bài viết!";
    }
}
?>