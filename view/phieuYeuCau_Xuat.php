<?php
include("../php/connect.php");
include("../php/header_heThong.php");
include("../php/sidebar_heThong.php");
?>

<?php
include("../php/thongBao.php");
?>
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Phiếu yêu cầu">Phiếu yêu cầu</div>


            <?php
            include("../php/thongBao.php");
            ?>

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
                            <option value="3">Chờ duyệt</option>
                            <option value="4">Đã duyệt</option>
                            <option value="5">Đã hủy</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Phiếu xuất</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example"
                                    class="table table-striped table-bordered table-responsive data-table"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Mã phiếu</th>
                                            <th>Tên phiếu</th>
                                            <th>Người lập</th>
                                            <th>Ngày lập phiếu</th>
                                            <th>Ngày xuất hàng</th>
                                            <th>Ngày giao hàng</th>
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

</main>
<script>
    // Lưu giá trị đã chọn vào localStorage
    document.getElementById("findRequest").addEventListener("click", function () {
        // Lấy giá trị của loại phiếu được chọn
        var selectedOption = document.querySelector('input[name="LocPhieu"]:checked').value;

        // Lưu giá trị đã chọn vào localStorage
        localStorage.setItem("selectedOption", selectedOption);

        if (selectedOption === "2") {
            // Điều hướng đến trang phiếu nhập
            window.location.href = "./phieuYeuCau.php";
        } else if (selectedOption === "1") {
            // Điều hướng đến trang phiếu xuất
            window.location.href = "./phieuYeuCau_Xuat.php";
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
<script type="text/javascript" src="../js/phieuYeuCau_Xuat.js"></script>

</body>

</html>