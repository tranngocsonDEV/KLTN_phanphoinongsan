<?php
include("../php/header_heThong.php");
?>


<?php
include("../php/sidebar_heThong.php");
?>
<?php
include("../config/init.php");
?>
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3">Tạo bài viết truy xuất nguồn gốc</div>
        </div>
        <?php
        include("../php/thongBao.php");
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form enctype="multipart/form-data" method="POST">
                            <div class="mb-3">
                                <label for="title" class="form-label">Tiêu đề:</label>
                                <input type="text" class="form-control" name="TieuDe"
                                    placeholder="Nhập tiêu đề bài viết" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Nội dung:</label>
                                <textarea class="form-control" name="NoiDung" rows="6"
                                    placeholder="Nhập nội dung bài viết" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Hình ảnh:</label>
                                <input type="file" class="form-control" name="HinhAnh" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="source" class="form-label">Nguồn gốc:</label>
                                <input type="text" class="form-control" name="NguonGoc"
                                    placeholder="Nhập nguồn gốc bài viết" required>
                            </div>
                            <div class="form-group">
                                <label control-label>Tên sản phẩm</label>
                                <select name="MaSanPham" class="form-select" aria-label="MaSanPham" required>
                                    <option selected disabled>Lựa chọn</option>
                                    <?php
                                    $query = ("SELECT  tbl_sanpham.MaSanPham, tbl_sanpham.Ten FROM tbl_sanpham 
                                    LEFT JOIN 
                                    tbl_baivietcuasanpham AS b
                                    ON tbl_sanpham.MaSanPham = b.MaSanPham
                                    WHERE b.MaSanPham IS NULL");
                                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $row['MaSanPham']; ?>"
                                                data-masanpham="<?php echo $row['MaSanPham']; ?>">
                                                <?php echo $row['Ten']; ?>
                                            </option>

                                        <?php }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="buttons mt-2">
                                <div class="d-grid gap-2 d-md-block">
                                    <button type="submit" name="btntaomoibaiviet" class="btn btn-primary btn-lg">Đăng
                                        Bài</button>
                                    <a href="./nvBaiVietTruyXuatNG.php"><button type="button"
                                            class="btn btn-secondary btn-lg">Quay
                                            lại</button></a>
                                </div>
                            </div>
                            <script>
                                document.querySelector('select[name="MaSanPham"]').addEventListener('change', function () {
                                    const selectedOption = this.options[this.selectedIndex];
                                    const maSanPham = selectedOption.getAttribute('data-masanpham');

                                    document.querySelector('input[name="MaSanPham"]').value = maSanPham;
                                });

                            </script>
                        </form>
                        <?php
                        if (isset($_POST["btntaomoibaiviet"])) {
                            // Kiểm tra xem MaSanPham có được chọn không
                            if (!isset($_POST["MaSanPham"]) || empty($_POST["MaSanPham"])) {
                                $_SESSION['errorMessages'] = "Vui lòng chọn sản phẩm!";
                                exit;
                            }

                            // Lấy thông tin từ form
                            $MaSanPham = $_POST["MaSanPham"];
                            $TieuDe = $_POST["TieuDe"];
                            $NoiDung = $_POST["NoiDung"];
                            $NguonGoc = $_POST["NguonGoc"];
                            $errors = [];

                            // Kiểm tra xem tệp có được tải lên không
                            if (isset($_FILES["HinhAnh"]) && $_FILES["HinhAnh"]["error"] == 0) {
                                // Xử lý file ảnh
                                $targetDir = "../img/";
                                $targetFile = $targetDir . basename($_FILES["HinhAnh"]["name"]);
                                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                                // Kiểm tra loại file hợp lệ
                                $allowedFormats = ["jpg", "jpeg", "png", "gif"];
                                if (in_array($imageFileType, $allowedFormats)) {
                                    if ($_FILES["HinhAnh"]["size"] > 5000000) {
                                        echo "Tệp ảnh quá lớn (tối đa 5MB).";
                                        exit;
                                    }
                                    if (move_uploaded_file($_FILES["HinhAnh"]["tmp_name"], $targetFile)) {
                                        $HinhAnh = basename($_FILES["HinhAnh"]["name"]);
                                    } else {

                                        $_SESSION['errorMessages'] = "Lỗi khi tải lên file.";
                                        header("Location:nvBaiVietTruyXuatNG_Tao.php");
                                        exit;
                                    }
                                } else {
                                    $_SESSION['errorMessages'] = "Chỉ chấp nhận các định dạng JPG, JPEG, PNG & GIF.";
                                    header("Location:nvBaiVietTruyXuatNG_Tao.php");
                                    exit;
                                }
                            } else {
                                $_SESSION['errorMessages'] = "Chưa chọn tệp hoặc có lỗi khi tải lên.";
                                header("Location:nvBaiVietTruyXuatNG_Tao.php");
                                exit;
                            }

                            // Tiến hành lưu bài viết vào cơ sở dữ liệu
                            $sql = "INSERT INTO `tbl_baivietcuasanpham`(`MaBaiViet`, `MaSanPham`, `TieuDe`, `NoiDung`, `HinhAnh`, `NguonGoc`, `QR_IMG`) 
                                VALUES (NULL, '$MaSanPham', '$TieuDe', '$NoiDung', '$HinhAnh', '$NguonGoc', NULL)";

                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                $_SESSION['message'] = "Tạo bài viết thành công!";
                                echo "<script>window.location.href = '../view/nvBaiVietTruyXuatNG.php';</script>";
                                exit;
                            } else {
                                echo "Lỗi khi tạo bài viết!";
                            }
                        }


                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
</body>

</html>