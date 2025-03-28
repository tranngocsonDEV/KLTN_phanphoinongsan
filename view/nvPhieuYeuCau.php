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
<?php
include("../php/header_heThong.php");
?>
<?php
include("../php/sidebar_heThong.php");
?>


<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Phiếu yêu cầu">Phiếu yêu cầu</div>

            <div class="row">

                <?php
                include("../php/thongBao.php");
                ?>
                <div class="col-md-4">
                    <div class="taophieunhap">
                        <a href="../view/taoPhieuYeuCauNhap.php">
                            <button class="btn  btn-success btn-md"
                                style=" float: left;padding: 5px; margin-bottom: 10px; margin-right:10px;">Tạo phiếu
                                nhập</button>
                        </a>
                    </div>
                    <div class="taophieuxuat">
                        <a href="../view/taoPhieuYeuCauXuat.php">
                            <button class="btn  btn-success btn-md"
                                style=" float: left;padding: 5px; margin-bottom: 10px; margin-right:20px; ">Tạo phiếu
                                xuất</button>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Phân phoại phiếu -->
            <div class="phanLoaiPhieu d-flex">
                <!-- Loại phiếu -->
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Loại phiếu
                            </button>
                            <div class="dropdown-menu p-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="LocPhieu" value="2"
                                        id="LocPhieuNhap" checked>
                                    <label class="form-check-label" for="LocPhieuNhap">Phiếu nhập</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="LocPhieu" value="1"
                                        id="LocPhieuXuat">
                                    <label class="form-check-label" for="LocPhieuXuat">Phiếu xuất</label>
                                </div>
                                <div class="d-grid gap-2" style="width: 100%;">
                                    <button type="button" id="findRequest" class="btn btn-primary action">ÁP
                                        DỤNG</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lọc phiếu -->
                <div class="row mx-2">
                    <div class="col">
                        <select class="form-select form-select-md" id="trangThaiSelect">
                            <option selected disabled>Trạng thái</option>
                            <option value="1">Chờ kiểm tra</option>
                            <option value="4">Đã duyệt</option>
                            <option value="5">Đã hủy</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Phiếu nhập</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example"
                                    class="table table-striped table-bordered table-responsive data-table "
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Mã phiếu</th>
                                            <th>Tên phiếu</th>
                                            <th>Người lập</th>
                                            <th>Ngày lập phiếu</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Ngày nhận hàng</th>
                                            <th>Tổng số loại sản phẩm</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal xác nhận xóa -->
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="../view/nvphieuYeuCau_Nhap_ChiTiet_Xoa.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteConfirmLabel">Xác nhận xóa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc chắn muốn xóa phiếu nhập này không?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</main>

<script>
    // Lưu giá trị đã chọn vào localStorage
    document.getElementById("findRequest").addEventListener("click", function () {
        // Lấy giá trị của loại phiếu được chọn
        var selectedOption = document.querySelector('input[name="LocPhieu"]:checked').value;

        // Lưu giá trị đã chọn vào localStorage
        localStorage.setItem("selectedOption", selectedOption);

        // Kiểm tra giá trị và điều hướng đến trang tương ứng
        if (selectedOption === "2") {
            // Điều hướng đến trang phiếu nhập
            window.location.href = "./nvPhieuYeuCau.php";
        } else if (selectedOption === "1") {
            // Điều hướng đến trang phiếu xuất
            window.location.href = "./nvPhieuYeuCau_Xuat.php";
        }
    });

    // Khi tải trang, đặt trạng thái checked cho radio button dựa trên giá trị trong localStorage
    document.addEventListener("DOMContentLoaded", function () {
        // Lấy giá trị đã lưu trong localStorage
        var selectedOption = localStorage.getItem("selectedOption");

        // Nếu có giá trị đã lưu, đặt trạng thái checked cho radio button
        if (selectedOption) {
            var radioButton = document.querySelector('input[name="LocPhieu"][value="' + selectedOption + '"]');
            if (radioButton) {
                radioButton.checked = true;
            }
        }
    });
</script>


</body>
<script type="text/javascript" src="../js/nvPhieuYeuCau.js"></script>

</html>