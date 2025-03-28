<?php
ob_start();
include("../php/header_heThong.php");
?>

<?php
include("../php/sidebar_heThong.php");
?>

<?php

include("../config/init.php");

if (isset($_POST['taoTaiKhoan'])) {
    $MaVaiTro = trim($_POST['MaVaiTro']);
    $manhanvien = trim($_POST['manhanvien']);
    $Ten = trim($_POST['Ten']);
    $SoDienThoai = trim($_POST['SoDienThoai']);
    $Email = trim($_POST['Email']);
    $errors = [];

    $checkMaNhanVien = "SELECT manhanvien FROM tbl_user WHERE manhanvien = '" . $manhanvien . "'";
    $checkMaNhanVien_run = mysqli_query($conn, $checkMaNhanVien);

    if (mysqli_num_rows($checkMaNhanVien_run) > 0) {
        $_SESSION['errorMessages'] = "Tài khoản đã tồn tại!";
        header("Location:capTaiKhoan.php");
        exit;
    } else {

    }
    if (empty($MaVaiTro)) {
        $errors[] = "Vui lòng nhập vai trò nhân viên!";
    } else {

    }
    if (empty($manhanvien)) {
        $errors[] = "Vui lòng nhập mã nhân viên!";
    } else {

    }
    if (!empty($errors)) {
        $_SESSION['errorMessages'] = $errors;
        header("Location: capTaiKhoan.php");
        exit;
    }
    $hashedPassword = password_hash("12345678", PASSWORD_DEFAULT);


    $sql = "INSERT INTO tbl_user (MaVaiTro, manhanvien, password, Email, Ten, SoDienThoai) VALUES ('$MaVaiTro', '$manhanvien', '$hashedPassword', '$Email', '$Ten', '$SoDienThoai')";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['message'] = "Thêm tài khoản thành công!";
        header("Location:capTaiKhoan.php");
        exit;
    } else {
        $_SESSION['errorMessages'] = "Có lỗi xảy ra! Lỗi khi thêm tài khoản: ";
        header("Location:capTaiKhoan.php");
        exit;
    }

}
mysqli_close($conn);
?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Cấp tài khoản">Cấp tài khoản</div>
        </div>
        <br />
        <br />
        <form class="form" action="capTaiKhoan.php" method="POST">
            <div class="card">

                <div class="card-body">
                    <div class="mb-3 form-group">
                        <label for="loaitaikhoan" class="form-label">Loại tài khoản</label>
                        <select class="form-select" aria-label="Default select example" id="vaitro" name="MaVaiTro"
                            required>
                            <option selected disabled>Vai trò</option>
                            <option value="2">Nhân viên kho</option>
                            <option value="3">Nhân viên kiểm kê</option>
                            <option value="4">Nhân viên giao hàng</option>
                        </select>
                    </div>
                    <?php

                    include("../php/thongBao.php");
                    ?>
                    <div class="mb-3 form-group">
                        <label for="manhanvien" class="form-label">Mã nhân viên</label>
                        <input type="number" class="form-control" id="manhanvien" name="manhanvien" minlength="6"
                            maxlength="10" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="Ten" class="form-label">Tên nhân viên</label>
                        <input type="text" class="form-control" id="Ten" name="Ten" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="SoDienThoai" class="form-label">Số điện thoại</label>
                        <input type="number" class="form-control" id="SoDienThoai" name="SoDienThoai" minlength="9"
                            maxlength="12" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email" required>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-success btn-lg" type="submit" name="taoTaiKhoan" value="Tạo tài khoản">
                            <i class="bi bi-plus"></i>
                            Tạo tài khoản
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered table-responsive "
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Loại nhân viên</th>
                                <th>Mã nhân viên</th>
                                <th>Tên nhân viên</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Hoạt động</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("../php/connect.php");
 
                           
                            $sql = "SELECT u.IDNhanVien, vt.TenVaiTro, u.manhanvien, Ten, SoDienThoai, Email, TrangThaiLamViec
                            FROM tbl_user AS u
                            JOIN tbl_vaitro AS vt 
                            ON u.MaVaiTro = vt.MaVaiTro
                            ORDER BY u.MaVaiTro ASC";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                // Sử dụng class thay cho enum
                         $isWorking = $row['TrangThaiLamViec'] === 'DangLamViec';

                                $soDienThoaiAn = anSoDienThoai($row['SoDienThoai']);

                                echo "<tr>";
                                echo "<td>" . $row['IDNhanVien'] . "</td>";
                                echo "<td>" . $row['TenVaiTro'] . "</td>";
                                echo "<td>" . $row['manhanvien'] . "</td>";
                                echo "<td>" . $row['Ten'] . "</td>";
                                echo "<td>" . $soDienThoaiAn . "</td>";
                                echo "<td>" . $row['Email'] . "</td>";

                                echo "<td>
                                    <div class='form-check form-switch'>
                                        <input class='form-check-input trangthai-switch' type='checkbox' role='switch' 
                                            id='TrangThaiLamViec_" . $row['IDNhanVien'] . "'  data-email
                                            data-idnhanvien='" . $row['IDNhanVien'] . "' 
                                            " . ($isWorking ? 'checked' : '') . ">
                                    </div>
                                    </td>";
                                echo "<td><button class='btn btn-secondary reset-password' data-idnhanvien='" . $row['IDNhanVien'] . "' data-email='" . $row['Email'] . "'>Reset mật khẩu</button></td>";
                                echo "</tr>";
                            }
                            ?>
                            <?php
                            function anSoDienThoai($soDienThoai)
                            {
                                // Kiểm tra độ dài của số điện thoại
                                $doDai = strlen($soDienThoai);
                                if ($doDai > 4) {
                                    // Lấy 4 số cuối
                                    $soCuoi = substr($soDienThoai, -4);
                                    // Ẩn các ký tự đầu bằng dấu *
                                    return str_repeat('*', $doDai - 4) . $soCuoi;
                                }
                                return $soDienThoai; // Trả về nguyên gốc nếu số điện thoại không hợp lệ
                            }
                            ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>
</body>
<!-- Modal xác nhận -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Xác nhận thay đổi trạng thái</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn thay đổi trạng thái làm việc của nhân viên này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" id="confirmButton" class="btn btn-primary">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận reset mật khẩu -->
<div class="modal fade" id="confirmResetModal" tabindex="-1" aria-labelledby="confirmResetModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmResetModalLabel">Xác nhận reset mật khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn reset mật khẩu cho nhân viên này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="confirmResetButton">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!-- Mail -->
<script>

    document.querySelectorAll(".reset-password").forEach(button => {
        button.addEventListener("click", () => {
            // Lưu ID và email của nhân viên cần reset
            idNhanVienToReset = button.getAttribute("data-idnhanvien");
            emailToReset = button.getAttribute("data-email");

            // Hiển thị modal xác nhận
            const modal = new bootstrap.Modal(document.getElementById("confirmResetModal"));

            modal.show();
        });
    });

    // Thực hiện reset mật khẩu khi người dùng xác nhận trong modal
    document.getElementById("confirmResetButton").addEventListener("click", () => {
        $.ajax({
            url: "../php/reset_password.php",
            type: "POST",
            dataType: "json", // Đảm bảo phản hồi là JSON
            data: {
                IDNhanVien: idNhanVienToReset,
                Email: emailToReset
            },
            success: function (response) {
                if (response.status === "success") {
                    alert(response.message);
                } else {
                    alert("Password reset failed: " + response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error:", errorThrown);
                alert("An error occurred.");
            }
        });
    });

</script>



<script>
    // Lắng nghe sự kiện thay đổi trạng thái checkbox
    document.querySelectorAll('.trangthai-switch').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const idNhanVien = this.getAttribute('data-idnhanvien');
            const newStatus = this.checked ? 'DangLamViec' : 'NghiViec';

            // Hiển thị modal xác nhận
            $('#confirmationModal').modal('show');

            // Xử lý khi người dùng xác nhận thay đổi
            document.getElementById('confirmButton').onclick = function () {
                updateStatus(idNhanVien, newStatus);
                $('#confirmationModal').modal('hide');
            };
        });
    });

    // Hàm cập nhật trạng thái
    function updateStatus(idNhanVien, newStatus) {
        fetch('../php/updateStatus.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ IDNhanVien: idNhanVien, TrangThaiLamViec: newStatus })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cập nhật trạng thái thành công');
                } else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
    }

</script>


</html>
<?php
ob_end_flush();

?>