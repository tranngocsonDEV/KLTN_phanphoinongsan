<?php include("../php/header_heThong.php"); ?>

<?php include("../php/sidebar_heThong.php"); ?>
<?php
include("../config/init.php");
?>
<?php
include("../php/thongBao.php");

// Kiểm tra xem có tham số MaBaiViet trong URL hay không
if (isset($_GET['MaBaiViet'])) {
    $MaBaiViet = $_GET['MaBaiViet'];

    // Truy vấn thông tin bài viết từ cơ sở dữ liệu
    $sql = "SELECT * FROM tbl_baivietcuasanpham WHERE MaBaiViet = '$MaBaiViet'";
    $result = mysqli_query($conn, $sql);

    // Kiểm tra xem bài viết có tồn tại không
    if (mysqli_num_rows($result) > 0) {
        // Lấy dữ liệu bài viết
        $row = mysqli_fetch_assoc($result);
        $HinhAnh = $row['HinhAnh']; // Nếu có hình ảnh, bạn sẽ lấy ở đây
        $TieuDe = $row['TieuDe'];
        $NoiDung = $row['NoiDung'];
        $NguonGoc = $row['NguonGoc'];


    } else {
        echo '<p>Bài viết không tồn tại.</p>';
    }
} else {
    echo '<p>Không có mã bài viết.</p>';
}
?>
<main class="mt-5 pt-3">
    <style>
        .img_div img {
            max-width: 300px;
            /* Điều chỉnh kích thước tùy theo giao diện */
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            dis
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3">Tạo Bài Viết và Truy Xuất Nguồn Gốc</div>
        </div>
        <?php
        include("../php/thongBao.php");
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="position-relative">
                            <!-- Phần hình ảnh hiển thị ở góc phải -->
                            <div class="img_div d-flex align-items-end flex-column">
                                <?php
                                echo '<img src="../img/' . $HinhAnh . '" alt="Hình ảnh bài viết" class="img-thumbnail shadow">';
                                ?>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Mã bài viết:</label>
                                <input type="text" class="form-control" name="MaBaiViet"
                                    value="<?php echo "$MaBaiViet"; ?>" placeholder="Mã bài viết">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Tiêu đề:</label>
                                <input type="text" class="form-control" name="TieuDe" value="<?php echo "$TieuDe"; ?>"
                                    placeholder="Nhập tiêu đề bài viết">
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Nội dung:</label>
                                <input type="text" class="form-control" name="NoiDung" value="<?php echo "$NoiDung"; ?>"
                                    placeholder="Nhập nội dung bài viết">
                            </div>
                            <div class="mb-3">
                                <label for="source" class="form-label">Nguồn gốc:</label>
                                <input type="text" class="form-control" name="NguonGoc"
                                    value="<?php echo "$NguonGoc"; ?>" placeholder="Nhập nguồn gốc bài viết">
                            </div>

                            <div class="buttons mt-3">
                                <a href="nvBaiVietTruyXuatNG.php"><button type="button"
                                        class="btn btn-secondary btn-lg ">Quay
                                        lại</button></a>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

</body>

</html>