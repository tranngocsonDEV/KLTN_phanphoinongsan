<?php include("../php/header_heThong.php"); ?>
<?php include("../php/sidebar_heThong.php"); ?>

<?php
include("../config/init.php");
include("../php/thongBao.php");

?>
<?php
include("../php/connect.php");

if (isset($_GET['MaBaiViet'])) {
    $MaBaiViet = $_GET['MaBaiViet'];
    $query = "SELECT * FROM tbl_baivietcuasanpham WHERE MaBaiViet = '$MaBaiViet'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data) {
        echo "Bài viết không tồn tại.";
        exit;
    }
} else {
    echo "Không có mã bài viết.";
    exit;
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
            <div class="col-md-12 fw-bold fs-3">Sửa Thông Tin Bài Viết</div>
        </div>
        <?php
        include("../php/thongBao.php");
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="../php/nvBaiVietTruyXuatNG_Sua_XuLy.php" method="POST"
                            enctype="multipart/form-data">
                            <!-- Phần hình ảnh hiển thị ở góc phải -->
                            <div class="mb-3 img_div d-flex align-items-end flex-column">
                                <label for="image" class="form-label">Hình ảnh hiện tại</label>
                                <div>
                                    <img src="../img/<?php echo $data['HinhAnh']; ?>" alt="Hình ảnh bài viết"
                                        class="img-thumbnail" style="width: 100%;">
                                </div>
                                <input type="file" class="form-control mt-2" name="HinhAnh" accept="image/*">
                                <input type="hidden" name="HinhAnhCu" value="<?php echo $data['HinhAnh']; ?>">

                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Mã bài viết:</label>
                                <input type="text" class="form-control" name="MaBaiViet"
                                    value="<?php echo "$MaBaiViet"; ?>" placeholder="Mã bài viết" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Tiêu đề:</label>
                                <input type="text" class="form-control" name="TieuDe"
                                    value="<?php echo htmlspecialchars($data['TieuDe']); ?>" required>

                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Nội dung:</label>
                                <textarea class="form-control" name="NoiDung" rows="6"
                                    required><?php echo htmlspecialchars($data['NoiDung']); ?></textarea>

                            </div>
                            <div class="mb-3">
                                <label for="source" class="form-label">Nguồn gốc:</label>
                                <input type="text" class="form-control" name="NguonGoc"
                                    value="<?php echo htmlspecialchars($data['NguonGoc']); ?>" required>

                            </div>

                            <div class="buttons mt-3">
                                <button type="submit" name="btn_update_article" class="btn btn-success">Sửa bài
                                    viết</button>

                                <a href="nvBaiVietTruyXuatNG.php"><button type="button" class="btn btn-secondary">Quay
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