<?php
include("../config/init.php");
include("../php/thongBao.php");


if (isset($_POST['btn_request_liquidation'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    $MaSanPham = intval($_POST['MaSanPham_text']);
    $thoiDiemThanhLy = $_POST['thoiDiemThanhLySoLuongSanPham'];
    $loaiThanhLy = $_POST['loaiThanhLySoLuongSanPham'];
    $soLuong = intval($_POST['soLuongThanhLySoLuongSanPham']);
    $ghiChu = $_POST['ghiChuThanhLySoLuongSanPham'];
    $IDNhanVien = $_POST['IDNhanVien'];

    if (!isset($_POST['thoiDiemThanhLySoLuongSanPham']) || empty($_POST['thoiDiemThanhLySoLuongSanPham'])) {
        $_SESSION['errorMessages'] = "Vui lòng chọn thời điểm thanh lý!";
        echo "<script>
                window.location.href = 'nvQuanLyKho.php';
                </script>";
        exit;
    }
    if (!isset($_POST['loaiThanhLySoLuongSanPham']) || empty($_POST['loaiThanhLySoLuongSanPham'])) {
        $_SESSION['errorMessages'] = "Vui lòng chọn loại thanh lý!";
        echo "<script>
                window.location.href = 'nvQuanLyKho.php';
                </script>";
        exit;
    }

    if ($_POST['soLuongThanhLySoLuongSanPham'] == 0) {
        $_SESSION['errorMessages'] = "Vui lòng nhập số lượng thanh lý hợp lệ!";
        echo "<script>
                window.location.href = 'nvQuanLyKho.php';
                </script>";
        exit;
    }
    if (!isset($_POST['soLuongThanhLySoLuongSanPham']) || !is_numeric($_POST['soLuongThanhLySoLuongSanPham']) || $_POST['soLuongThanhLySoLuongSanPham'] < 0 || empty($_POST['soLuongThanhLySoLuongSanPham'])) {
        $_SESSION['errorMessages'] = "Số lượng thanh lý phải là số không âm và hợp lệ!";
        echo "<script>
                window.location.href = 'nvQuanLyKho.php';
                </script>";
        exit;
    }
    $sql = "SELECT SoLuongTon FROM tbl_sanpham WHERE MaSanPham = ?";
    $stmt = $conn->prepare($sql); // Sử dụng prepared statement để bảo mật
    $stmt->bind_param("s", $MaSanPham); // Gắn tham số (nếu MaSanPham là chuỗi)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy giá trị TongSoLuong từ kết quả
        $row = $result->fetch_assoc();
        $tongSoLuong = intval($row['SoLuongTon']);

        // Kiểm tra soLuongThanhLy có lớn hơn TongSoLuong hay không
        if ($soLuong > $tongSoLuong) {
            $_SESSION['errorMessages'] = "Số lượng thanh lý không được vượt quá số lượng tồn hiện có là $tongSoLuong!";
            header("Location: nvQuanLyKho.php");
            exit;
        } elseif ($tongSoLuong == 0) {
            $_SESSION['errorMessages'] = "Không thể thanh lý vì số lượng tồn hiện có là $tongSoLuong!";
            header("Location: nvQuanLyKho.php");
            exit;
        }
    } else {
        // Không tìm thấy sản phẩm
        $_SESSION['errorMessages'] = "Không tìm thấy sản phẩm với mã $MaSanPham!";
        header("Location: nvQuanLyKho.php");
        exit;
    }
    // Insert data into `tbl_yeucau_thanhly` with status "Chờ duyệt"
    $sql = "INSERT INTO tbl_thanhly (MaSanPham, MaNguoiTao, MaTrangThaiPhieu, ThoiGian, SoLuong, LoaiThanhLy, GhiChu)
            VALUES ( '$MaSanPham', '$IDNhanVien', 17, '$thoiDiemThanhLy', '$soLuong', '$loaiThanhLy', '$ghiChu')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Đề xuất thanh lý đã được gửi thành công và đang chờ duyệt.";
    } else {
        $_SESSION['errorMessages'] = "Gửi đề xuất thanh lý không thành công.";
    }

    header("Location: nvQuanLyKho.php");
    exit;
}


?>