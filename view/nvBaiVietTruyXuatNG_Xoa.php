<?php
include("../config/init.php");
include("../php/thongBao.php");

if (isset($_POST["btn_article_delete"])) {
    // Lấy thông tin MaBaiViet từ form
    $MaBaiViet = $_POST["MaBaiViet"];

    // Tiến hành xóa bài viết khỏi cơ sở dữ liệu
    $sql = "DELETE FROM tbl_baivietcuasanpham WHERE MaBaiViet = '$MaBaiViet'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $_SESSION['errorMessages'] = "Lỗi khi xóa bài viết!";
        echo "<script>
                window.location.href = '../view/nvBaiVietTruyXuatNG.php';
              </script>";
        exit;
    } else {
        $_SESSION['message'] = "Xóa bài viết thành công!";
        echo "<script>
                window.location.href = '../view/nvBaiVietTruyXuatNG.php';
              </script>";
        exit;
    }
}
?>