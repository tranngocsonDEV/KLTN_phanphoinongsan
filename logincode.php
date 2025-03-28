<?php
include("../config/init.php"); // Khởi tạo session và các cài đặt ban đầu
include("../php/connect.php"); // Kết nối cơ sở dữ liệu

ob_start();

// Xử lý khi người dùng bấm nút đăng nhập
if (isset($_POST['submit'])) {
    $userName = trim($_POST["Username"]);
    $password = trim($_POST["Password"]);

    // Kiểm tra các trường không được để trống
    if (!empty($userName) && !empty($password)) {
        // Truy vấn với prepared statement để tránh SQL Injection
        $login_query = "SELECT IDNhanVien, MaNhanVien, password, TrangThaiLamViec, tbl_user.MaVaiTro, tbl_vaitro.TenVaiTro, Ten, SoDienThoai, Email
                        FROM tbl_user
                        JOIN tbl_vaitro ON tbl_user.MaVaiTro = tbl_vaitro.MaVaiTro
                        WHERE MaNhanVien = ? LIMIT 1";

        if ($stmt = mysqli_prepare($conn, $login_query)) {
            mysqli_stmt_bind_param($stmt, "s", $userName);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                // Kiểm tra trạng thái làm việc của nhân viên
                if ($row['TrangThaiLamViec'] === 'NghiViec') {
                    $_SESSION['errorMessages'] = "Tài khoản đã bị khóa hoặc nhân viên đã nghỉ việc!";
                    header("Location: login.php");
                    exit;
                }

                // Kiểm tra mật khẩu nhập vào với mật khẩu đã hash
                if (password_verify($password, $row['password'])) {
                    // Đăng nhập thành công: lưu thông tin vào session
                    $_SESSION["auth"] = true;
                    $_SESSION["TenVaiTro"] = $row["TenVaiTro"];
                    $_SESSION["MaVaiTro"] = $row["MaVaiTro"];
                    $_SESSION["ThongTinDangNhap"] = [
                        'User_id' => $row['IDNhanVien'],
                        'Username' => $row['MaNhanVien'],
                        'MaVaiTro' => $row['MaVaiTro'],
                        'TenVaiTro' => $row['TenVaiTro'],
                        'Ten' => $row['Ten'],
                        'SoDienThoai' => $row['SoDienThoai'],
                        'Email' => $row['Email'],
                    ];

                    // Điều hướng người dùng đến trang tương ứng với vai trò
                    switch ($_SESSION["MaVaiTro"]) {
                        case '1': // Quản lý hệ thống
                            $_SESSION['message'] = "Đăng nhập thành công";
                            header("Location: thongKe.php");
                            break;
                        case '2': // Nhân viên kho
                            $_SESSION['message'] = "Đăng nhập thành công";
                            header("Location: nvPhieuYeuCau.php");
                            break;
                        case '3': // Nhân viên kiểm kê
                            $_SESSION['message'] = "Đăng nhập thành công";
                            header("Location: nvkkPhieuBienBan.php");
                            break;
                        case '4': // Nhân viên vận chuyển
                            $_SESSION['message'] = "Đăng nhập thành công";
                            header("Location: nvvcPhanPhoiDonHang.php");
                            break;
                        default:
                            $_SESSION['errorMessages'] = "Không xác định vai trò người dùng!";
                            header("Location: login.php");
                            break;
                    }
                    exit;
                } else {
                    $_SESSION['errorMessages'] = "Sai tên người dùng hoặc mật khẩu!";
                }
            } else {
                $_SESSION['errorMessages'] = "Tài khoản không tồn tại!";
            }

            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['errorMessages'] = "Có lỗi xảy ra trong quá trình đăng nhập!";
        }
    } else {
        $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin!";
    }

    // Quay lại trang đăng nhập kèm thông báo lỗi
    header("Location: login.php");
    exit;
}
?>
