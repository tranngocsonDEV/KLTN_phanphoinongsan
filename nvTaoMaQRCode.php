
<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<?php
include("../config/init.php"); // Khởi tạo session và các cài đặt ban đầu
include("../php/connect.php"); // Kết nối cơ sở dữ liệu

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['ThongTinDangNhap']) || !isset($_SESSION['MaVaiTro'])) {
    $_SESSION['errorMessages'] = "Bạn phải đăng nhập để truy cập trang này!";
    header("Location: login.php");
    exit;
}

// Kiểm tra quyền truy cập: chỉ nhân viên kho (MaVaiTro = 2) mới được truy cập
if ($_SESSION['MaVaiTro'] != '2') {
    $_SESSION['errorMessages'] = "Bạn không có quyền truy cập trang này!";
    header("Location: login.php");
    exit;
}

// Nếu vượt qua kiểm tra quyền truy cập, hiển thị trang thống kê
?>
<?php include("../php/header_heThong.php"); ?>

<?php include("../php/sidebar_heThong.php"); ?>


<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <?php

            include("../php/thongBao.php");
            ?>
            <div class="box-qr">
                <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Tạo mã QR">Tạo mã QR</div>
                <div class="generate-qr">
                    <?php
                    if (isset($_SESSION['qrcode_base64'])) {
                        $base64Image = $_SESSION['qrcode_base64'];
                        echo '<img style"margin:0px; padding:0px;" id="qrcode-image" src="data:image/png;base64,' . $base64Image . '" alt="QR Code">';

                        // Xóa session sau khi hiển thị
                        unset($_SESSION['qrcode_base64']);
                    } else {
                        echo '<p>Chưa có mã QR code nào được tạo.</p>'; // Thông báo nếu chưa có QR code
                    }

                    ?>
                </div>
                <form action="createqrcode.php" method="post">

                    <div class="input-group mb-3">

                        <select name="tensanpham" id="requestSelect" class="form-control" aria-label="tensanpham"
                            required>
                            <option selected disabled>Chọn sản phẩm</option>
                            <?php
                            $query = ("SELECT MaBaiViet, TieuDe
                                        FROM tbl_baivietcuasanpham
                                        WHERE QR_IMG IS NULL");
                            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                            if (mysqli_num_rows(result: $result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $row['MaBaiViet']; ?>"
                                        data-baiviet="<?php echo $row['MaBaiViet']; ?>">
                                        <?php echo $row['TieuDe']; ?>
                                    </option>

                                <?php }
                            }
                            ?>
                        </select>
                        <input type="hidden" name="productData" id="productData">

                    </div>

                    <div class="input-group mb-3">
                        <input type="text" name="linksanpham" placeholder="Link mô tả sản phẩm chi tiết"
                            class="form-control">
                    </div>
                    <div class="btn-qr ">
                        <div class="btn-them">
                            <button name="Add" value="Tạo QR" type="submit" class="btn btn-outline-success btn-lg"><i
                                    class="bi bi-qr-code"></i>Tạo QR</button>
                        </div>
                        <div class="btn-download">
                            <button type="button" id="download" class="btn btn-outline-primary btn-lg"><i
                                    class="bi bi-download"></i>Tải xuống</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</main>

<script>
    // Lấy tham chiếu đến nút tải xuống và ảnh QR code
    const downloadButton = document.getElementById("download");
    const qrcodeImage = document.getElementById("qrcode-image");

    // Thêm sự kiện click vào nút tải xuống
    downloadButton.addEventListener("click", function () {
        // Tạo liên kết tải xuống
        const link = document.createElement("a");
        link.href = qrcodeImage.src;
        link.download = "qrcode.png"; // Tên file tải xuống

        // Kích hoạt tải xuống
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
    document.getElementById('requestSelect').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const productsData = selectedOption.getAttribute('data-baiviet');

        // Gán giá trị của data-products vào trường ẩn
        document.getElementById('productData').value = productsData;
    });
</script>
</body>

</html>