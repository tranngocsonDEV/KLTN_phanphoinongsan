<?php
include("../php/header_heThong.php");
?>


<?php
include("../php/sidebar_heThong.php");
?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Thông tin">Thông tin</div>
        </div>
        <br />
        <br />
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="loaitaikhoan" class="form-label">Loại tài khoản</label>
                    <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>

                        <input type="text" class="form-control" id="vaiTro" value="<?= $_SESSION["TenVaiTro"]; ?>" />
                    <?php endif; ?>

                </div>
                <div class="mb-3">
                    <label for="manhanvien" class="form-label">Mã nhân viên</label>
                    <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>

                        <input type="text" class="form-control" id="maNhanVien" placeholder=""
                            value="<?= $_SESSION['ThongTinDangNhap']['Username']; ?>" />
                    <?php endif; ?>

                </div>
                <div class="mb-3">
                    <label for="Ten" class="form-label">Tên nhân viên</label>
                    <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>

                        <input type="text" class="form-control" id="Ten" placeholder=""
                            value="<?= $_SESSION['ThongTinDangNhap']['Ten']; ?>" />
                    <?php endif; ?>

                </div>
                <div class="mb-3">
                    <label for="SoDienThoai" class="form-label">Số điện thoại</label>
                    <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>

                        <input type="number" class="form-control" id="SoDienThoai" placeholder=""
                            value="<?= $_SESSION['ThongTinDangNhap']['SoDienThoai']; ?>" />
                    <?php endif; ?>

                </div>
                <div class="mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>

                        <input type="email" class="form-control" id="Email" placeholder=""
                            value="<?= $_SESSION['ThongTinDangNhap']['Email']; ?>" />
                    <?php endif; ?>

                </div>


            </div>
        </div>
    </div>
</main>
<script>
    function changeTypePass() {
        var x = document.getElementById("matKhau");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
</body>

</html>