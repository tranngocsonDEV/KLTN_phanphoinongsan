<?php
ob_start();

include("../php/header_heThong.php");
include("../php/sidebar_heThong.php");
include("../config/init.php");
include("../php/thongBao.php");

?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Chỉnh sửa thông tin">Chỉnh sửa thông tin
            </div>
        </div>
        <br />
        <br />
        <div class="card">
            <div class="card-body">
                <form action="thongTin_ChinhSua.php" method="POST">
                    <div class="mb-3">
                        <label for="loaitaikhoan" class="form-label">Loại tài khoản</label>
                        <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>
                            <input type="text" class="form-control" id="VaiTroNhanVien" disabled
                                value="<?= $_SESSION["TenVaiTro"]; ?>" />
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="manhanvien" class="form-label">Mã nhân viên</label>
                        <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>
                            <input type="text" class="form-control" id="maNhanVien"
                                value="<?= $_SESSION['ThongTinDangNhap']['Username']; ?>" disabled />
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="Ten" class="form-label">Tên nhân viên</label>
                        <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>
                            <input type="text" class="form-control" id="Ten" name="Ten"
                                value="<?= $_SESSION['ThongTinDangNhap']['Ten']; ?>" required />
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="SoDienThoai" class="form-label">Số điện thoại</label>
                        <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>
                            <input type="number" class="form-control" id="SoDienThoai" name="SoDienThoai"
                                value="<?= $_SESSION['ThongTinDangNhap']['SoDienThoai']; ?>" required />
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>
                            <input type="email" class="form-control" id="Email" name="Email"
                                value="<?= $_SESSION['ThongTinDangNhap']['Email']; ?>" required />
                        <?php endif; ?>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="matkhau" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" name="matKhau" id="matKhau"
                            placeholder="Nhập mật khẩu mới" required />
                        <i class="bi bi-eye-slash" id="eye-icon" onclick="changeTypePass()"
                            style="font-size: 2rem; position: absolute; right: 10px; color: #6c757d; top: 72%; transform: translateY(-50%); cursor: pointer;"></i>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-success btn-lg" type="submit" name="thayDoiThongTin">
                            <i class="bi bi-person-fill-gear"></i> Thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    function changeTypePass() {
        var x = document.getElementById("matKhau");
        var eyeIcon = document.getElementById("eye-icon");

        // Nếu mật khẩu đang ở kiểu password (ẩn)
        if (x.type === "password") {
            x.type = "text"; // Thay đổi kiểu thành text để hiển thị mật khẩu
            eyeIcon.classList.remove("bi-eye-slash"); // Xóa biểu tượng mắt bị chặn
            eyeIcon.classList.add("bi-eye"); // Thêm biểu tượng mắt mở
        } else {
            x.type = "password"; // Thay đổi kiểu thành password để ẩn mật khẩu
            eyeIcon.classList.remove("bi-eye"); // Xóa biểu tượng mắt mở
            eyeIcon.classList.add("bi-eye-slash"); // Thêm biểu tượng mắt bị chặn
        }
    }
</script>
</body>

</html>

<?php
// Xử lý thay đổi thông tin khi người dùng submit form
if (isset($_POST['thayDoiThongTin'])) {
    include("../config/init.php");

    // Lấy thông tin từ form
    $Ten = trim($_POST['Ten']);
    $SoDienThoai = trim($_POST['SoDienThoai']);
    $Email = trim($_POST['Email']);
    $matKhau = trim($_POST['matKhau']); // Mật khẩu mới

    // Xử lý mật khẩu (nếu có thay đổi)
    $newPassword = "";
    if (!empty($matKhau)) {
        $newPassword = password_hash($matKhau, PASSWORD_DEFAULT);
    }

    // Lấy mã nhân viên từ session
    $manhanvien = $_SESSION['ThongTinDangNhap']['Username'];

    // Kiểm tra xem có trường nào trống không
    if (empty($Ten) || empty($SoDienThoai) || empty($Email)) {
        $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin!";
        header("Location: thongTin_ChinhSua.php");
        exit;
    }

    // Cập nhật thông tin vào cơ sở dữ liệu
    $updateSql = "UPDATE tbl_user SET Ten = '$Ten', SoDienThoai = '$SoDienThoai', Email = '$Email'";

    if (!empty($newPassword)) {
        $updateSql .= ", password = '$newPassword'";
    }

    $updateSql .= " WHERE manhanvien = '$manhanvien'";

    if (mysqli_query($conn, $updateSql)) {
        $_SESSION['message'] = "Cập nhật thông tin thành công!";
        $_SESSION['ThongTinDangNhap']['Ten'] = $Ten;
        $_SESSION['ThongTinDangNhap']['SoDienThoai'] = $SoDienThoai;
        $_SESSION['ThongTinDangNhap']['Email'] = $Email;
        header("Location: thongTin_ChinhSua.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Lỗi khi cập nhật thông tin!";
        header("Location: thongTin_ChinhSua.php");
        exit;
    }

    mysqli_close($conn);
}
?>
<?php
ob_end_flush();

?>