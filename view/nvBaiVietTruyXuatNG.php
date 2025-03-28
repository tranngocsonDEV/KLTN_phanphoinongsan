<?php include("../php/header_heThong.php"); ?>

<?php include("../php/sidebar_heThong.php"); ?>
<?php
include("../config/init.php");
?>
<?php
include("../php/thongBao.php");
?>
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Quản lý bài viết">Quản lý bài viết</div>
            <div class="taophieunhap">
                <a href="../view/nvBaiVietTruyXuatNG_Tao.php">
                    <button class="btn btn-success btn-md"
                        style="border: none;  color: #fff; float: right;padding: 5px; margin-bottom: 10px;">Tạo bài
                        viết</button>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Bảng dữ liệu</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered table-responsive data-table"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Mã Bài Viết</th>
                                        <th>Tiêu Đề</th>
                                        <th>Nội Dung Bài Viết </th>
                                        <th>Nguồn Gốc</th>
                                        <th>Mã QR</th>
                                        <th>Hành động</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    include("../php/vproduct.php");
                                    $p = new vSanPham();

                                    $p->viewdsbaiviet();


                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Xác nhận Xóa -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Xóa Bài Viết</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa bài viết về <strong id="articleTitle"></strong> không?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <form id="deleteForm" action="nvBaiVietTruyXuatNG_Xoa.php" method="POST">
                            <input type="hidden" name="MaBaiViet" id="MaBaiViet">
                            <button type="submit" name="btn_article_delete" class="btn btn-danger">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Popup QR Code -->
        <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrCodeModalLabel">Mã QR</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="qrCodeImage" src="" alt="QR Code" class="img-fluid">
                    </div>
                    <div class="modal-footer">
                        <a id="downloadQRBtn" href="#" class="btn btn-success" download>Tải QR</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function openQRCodePopup(qrCodePath) {
                // Cập nhật đường dẫn mã QR vào popup
                document.getElementById('qrCodeImage').src = qrCodePath;
                // Cập nhật link tải về QR Code
                document.getElementById('downloadQRBtn').href = qrCodePath;
                // Mở modal
                var qrCodeModal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
                qrCodeModal.show();
            }

        </script>
        <script>
            // Lắng nghe sự kiện khi nút Xóa được nhấn
            document.addEventListener('DOMContentLoaded', function () {
                var deleteModal = document.getElementById('deleteModal');
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    // Lấy thông tin từ button đã nhấn
                    var button = event.relatedTarget; // Nút nhấn "Xóa"
                    var maBaiViet = button.getAttribute('data-mabv');
                    var tieuDe = button.getAttribute('data-tieude');

                    // Cập nhật tiêu đề bài viết trong modal
                    var modalTitle = deleteModal.querySelector('.modal-body #articleTitle');
                    modalTitle.textContent = tieuDe;

                    // Cập nhật giá trị MaBaiViet trong form
                    var form = deleteModal.querySelector('form');
                    form.querySelector('#MaBaiViet').value = maBaiViet;
                });
            });

        </script>

    </div>
</main>
</body>

</html>