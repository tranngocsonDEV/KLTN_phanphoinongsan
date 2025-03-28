<?php
include("../config/init.php");
include("../php/header_heThong.php");
?>
<?php
include("../php/sidebar_heThong.php");
?>


<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Yêu cầu đổi trả">Yêu cầu đổi trả</div>

            <div class="row">

                <?php
                include("../php/thongBao.php");
                ?>
                <div class="col-md-4">

                    <div class="tao_ycdt">
                        <a href="../view/nvTao_YeuCau_Nhap_DoiTra.php">
                            <button class="btn  btn-success btn-md"
                                style=" float: left;padding: 5px; margin-bottom: 10px; margin-right:20px; ">Tạo phiếu
                                nhập</button>
                        </a>
                        <a href="../view/nvTao_YeuCauDoiTra.php">
                            <button class="btn  btn-success btn-md"
                                style=" float: left;padding: 5px; margin-bottom: 10px; margin-right:20px; ">Tạo yêu cầu
                                đổi trả</button>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Phân phoại phiếu -->
            <div class="phanLoaiPhieu d-flex mb-2">

                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Loại phiếu
                            </button>
                            <div class="dropdown-menu p-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="LocPhieu" value="1"
                                        id="LocPhieuNhap" checked>
                                    <label class="form-check-label" for="LocPhieuNhap">Phiếu yêu cầu đổi trả</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="LocPhieu" value="2"
                                        id="LocPhieuXuat">
                                    <label class="form-check-label" for="LocPhieuXuat">Phiếu nhập</label>
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
                            <option value="1">Đã tạo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Phiếu đổi trả</div>
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
                    <form action="../view/nvPYC_DoiTra_ChiTiet_Xoa.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteConfirmLabel">Xác nhận xóa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc chắn muốn xóa phiếu đổi trả này không?
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

        // Xóa giá trị sau khi điều hướng
        setTimeout(function () {
            localStorage.removeItem("selectedOption");
        }, 100);

        // Kiểm tra giá trị và điều hướng đến trang tương ứng
        if (selectedOption === "1") {
            // Điều hướng đến trang phiếu nhập
            window.location.href = "./nvYeuCauDoiTra.php";
        } else if (selectedOption === "2") {
            // Điều hướng đến trang phiếu xuất
            window.location.href = "./nvYeuCauDoiTra_Nhap.php";
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
<script type="text/javascript" src="../js/nvPYC_DoiTra_Nhap.js"></script>

</html>