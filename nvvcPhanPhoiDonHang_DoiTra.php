<?php
include("../php/header_heThong.php");

?>
<?php
include("../php/sidebar_heThong.php");

?>
<?php
include("../php/thongBao.php");
include("../config/init.php");

?>
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Đơn hàng">Đơn hàng</div>
        </div>
        <div class="phanLoaiPhieu d-flex">
            <!-- Loại phiếu -->
            <div class="row mb-2">
                <div class="col-md-4">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Loại phiếu
                        </button>
                        <div class="dropdown-menu p-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="LocPhieu" value="3" id="LocPhieuNhap"
                                    checked>
                                <label class="form-check-label" for="LocPhieuNhap">Phiếu xuất</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="LocPhieu" value="4"
                                    id="LocPhieuXuat">
                                <label class="form-check-label" for="LocPhieuXuat">Yêu cầu đổi trả</label>
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
                <div class="input-group mb-3">
                    <select class="form-select" id="inputGroupSelect01">
                        <option value="" disabled selected>Chọn trạng thái</option>
                        <option selected value="8">Đã phân phối</option>
                        <option value="13">Đã giao hàng</option>
                    </select>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="MaShipperDangNhap" id="MaShipperDangNhap"
                            value="<?= $_SESSION['ThongTinDangNhap']['User_id']; ?>">
                    </div>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered table-responsive "
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Mã yêu cầu đổi trả</th>
                                    <th>Mã phiếu xuất</th>
                                    <th>Tên phiếu</th>
                                    <th>Người lập phiếu</th>
                                    <th>Ngày lập đổi trả</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                    </div>
                </div>
            </div>
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
        if (selectedOption === "3") {
            // Điều hướng đến trang phiếu xuất
            window.location.href = "./nvvcPhanPhoiDonHang.php";
        } else if (selectedOption === "4") {
            // Điều hướng đến trang phiếu đổi trả
            window.location.href = "./nvvcPhanPhoiDonHang_DoiTra.php";
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
<script type="text/javascript" src="../js/nvvcPhanPhoiDonHang_XacNhan_DoiTra.js"></script>
</body>

</html>