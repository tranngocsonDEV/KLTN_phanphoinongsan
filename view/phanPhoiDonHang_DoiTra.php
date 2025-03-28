<?php
include("../php/header_heThong.php");

?>
<?php
include("../php/sidebar_heThong.php");

?>
<?php
session_start();
include("../php/thongBao.php");
?>
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Phân phối">Phân phối</div>
        </div>
        <!-- Phân phoại phiếu -->
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
                        <option selected value="16">Chờ phân phối</option>
                        <option value="8">Đã phân phối</option>
                    </select>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

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
    document.getElementById("findRequest").addEventListener("click", function () {
        // Lấy radio đang được chọn
        var selectedRadio = document.querySelector('input[name="LocPhieu"]:checked');

        if (selectedRadio) {
            var selectedOption = selectedRadio.value;

            // Lưu trạng thái vào LocalStorage
            localStorage.setItem("selectedOption", selectedOption);

            // Điều hướng đến trang tương ứng
            if (selectedOption === "3") {
                window.location.href = "./phanPhoiDonHang.php";
            } else if (selectedOption === "4") {
                window.location.href = "./phanPhoiDonHang_DoiTra.php";
            }
        } else {
            alert("Vui lòng chọn một loại phiếu trước khi áp dụng!");
        }
    });

</script>
<script>
    // Lấy trạng thái từ LocalStorage
    const selectedOption = localStorage.getItem("selectedOption");

    // Đặt trạng thái "checked" cho radio button tương ứng
    if (selectedOption) {
        const radioToCheck = document.querySelector(`input[name="LocPhieu"][value="${selectedOption}"]`);
        if (radioToCheck) {
            radioToCheck.checked = true;
        }
    }

    // (Tùy chọn) Xóa dữ liệu khỏi LocalStorage nếu không cần giữ lâu
    localStorage.removeItem("selectedOption");

</script>
<script type="text/javascript" src="../js/phanPhoiDonHang_DoiTra.js"></script>
</body>

</html>