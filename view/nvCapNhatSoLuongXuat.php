<?php include("../php/header_heThong.php"); ?>

<?php include("../php/sidebar_heThong.php"); ?>

<?php include("../config/init.php"); ?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Xác nhận xuất kho">Xác nhận xuất kho
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Xuất kho</h3>
                    </div>
                    <?php

                    include("../php/thongBao.php");
                    ?>
                    <div class="card-body">
                        <div class="chitiet-row">
                            <form action="../php/nvCapNhatSoLuong_XuLy_Xuat.php" method="POST">
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="maphieu">Mã phiếu</label>
                                        <select name="maphieu" id="requestSelect" class="form-select"
                                            aria-label="maphieu" required>
                                            <option selected disabled>Lựa chọn</option>
                                            <!-- Mục Phiếu Xuất -->
                                            <optgroup label="Phiếu Xuất">
                                                <?php
                                                $query = "SELECT DISTINCT px.MaPhieuXuat AS MaPhieu,  px.NgayXuatHang, sp.Ten, ctpx.SoLuong,sp.MaSanPham, sp.DonVi
                                            FROM tbl_chitietphieuxuat AS ctpx
                                            JOIN tbl_sanpham AS sp ON ctpx.MaSanPham = sp.MaSanPham
                                            JOIN tbl_phieuxuat AS px ON px.MaPhieuXuat = ctpx.MaPhieuXuat
                                            WHERE px.MaTrangThaiPhieu = 4";

                                                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                                                $productsByRequest = [];
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $MaPhieuXuat = $row['MaPhieu'];
                                                    $NgayXuatHang = $row['NgayXuatHang'];
                                                    $MaSanPham = $row['MaSanPham'];
                                                    $TenSanPham = $row['Ten'];
                                                    $SoLuong = $row['SoLuong'];
                                                    $DonVi = $row['DonVi'];

                                                    if (!isset($productsByRequest[$MaPhieuXuat])) {
                                                        $productsByRequest[$MaPhieuXuat] = [
                                                            "NgayXuatHang" => $NgayXuatHang,
                                                            "products" => []
                                                        ];
                                                    }
                                                    $productsByRequest[$MaPhieuXuat]["products"][] = [
                                                        "MaSanPham" => $MaSanPham,
                                                        "TenSanPham" => $TenSanPham,
                                                        "SoLuong" => $SoLuong,
                                                        "DonVi" => $DonVi
                                                    ];
                                                }

                                                // Tạo <option> và lưu dữ liệu vào dạng JSON trong mỗi <option>
                                                foreach ($productsByRequest as $MaPhieuXuat => $data) {
                                                    echo "<option value='$MaPhieuXuat' data-type='phieu_xuat' data-ngayxuathang='{$data['NgayXuatHang']}' data-products='" . json_encode($data['products']) . "'>$MaPhieuXuat</option>";
                                                }
                                                ?>
                                            </optgroup>
                                            <optgroup label="Yêu Cầu Đổi Trả">
                                                <?php
                                                $queryDoiTra = "SELECT DISTINCT yc.MaYeuCauDoiTra AS MaPhieu, yc.NgayLapDoiTra AS NgayXuatHang, ct.MaSanPham, sp.Ten, ct.SoLuongDoiTra AS SoLuong, sp.DonVi 
                                                FROM tbl_chitietyeucaudoitra AS ct
                                                  JOIN tbl_sanpham AS sp
                                                ON sp.MaSanPham = ct.MaSanPham
                                                JOIN tbl_yeucaudoitra AS yc
                                                ON ct.MaYeuCauDoiTra = yc.MaYeuCauDoiTra
                                                WHERE yc.MaTrangThaiPhieu = 19";
                                                $resultDoiTra = mysqli_query($conn, $queryDoiTra) or die(mysqli_error($conn));
                                                $productsByRequest_DoiTra = [];

                                                while ($row = mysqli_fetch_assoc($resultDoiTra)) {
                                                    $MaYeuCau = $row['MaPhieu'];
                                                    $NgayXuatHang = $row['NgayXuatHang'];
                                                    $MaSanPham = $row['MaSanPham'];
                                                    $TenSanPham = $row['Ten'];
                                                    $SoLuong = $row['SoLuong'];
                                                    $DonVi = $row['DonVi'];

                                                    if (!isset($productsByRequest_DoiTra[$MaYeuCau])) {
                                                        $productsByRequest[$MaYeuCau] = [
                                                            "NgayXuatHang" => $NgayXuatHang,
                                                            "products" => []
                                                        ];
                                                    }
                                                    $productsByRequest_DoiTra[$MaYeuCau]["products"][] = [
                                                        "MaSanPham" => $MaSanPham,
                                                        "TenSanPham" => $TenSanPham,
                                                        "SoLuong" => $SoLuong,
                                                        "DonVi" => $DonVi
                                                    ];


                                                }
                                                // Tạo <option> và lưu dữ liệu vào dạng JSON trong mỗi <option>
                                                foreach ($productsByRequest_DoiTra as $MaYeuCau => $data) {
                                                    echo "<option value='$MaYeuCau' data-type='doi_tra'  data-ngayxuathang='$NgayXuatHang' data-products='" . json_encode($data['products']) . "'>$MaYeuCau</option>";
                                                }
                                                ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="NgayXuatKho">Ngày xuất kho</label>
                                        <input type="date" class="form-control" name="NgayXuatKho" id="NgayXuatKho"
                                            required>
                                    </div>
                                </div>
                        </div>
                        <dt class="col-sm-3 mb-4">Danh sách yêu cầu:</dt>
                        <table class="table table-striped table-bordered table-responsive mb-4" id="productList">
                            <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng theo phiếu</th>
                                    <th>Đơn vị</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <input type="hidden" id="type" name="type" value="">
                        <input type="hidden" name="productData" id="productData">

                        <div class="buttons">
                            <div class="d-grid gap-2 d-md-block">
                                <button type="submit" name="btn_confirm_request"
                                    class="tn btn-primary btn-lg btn_confirm_request_export">Xác
                                    nhận</button>
                                <a href="../view/nvCapNhatSoLuongXuat.php" class="btn btn-secondary btn-lg"
                                    tabindex="-1" role="button" aria-disabled="true">Quay lại</a>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Chọn phiếu xuất -->
    <script>
        document.getElementById('requestSelect').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const productsData = selectedOption.getAttribute('data-products');
            const type = selectedOption.dataset.type;

            document.getElementById("type").value = type;
            document.getElementById('productData').value = productsData;
        });
        document.addEventListener("DOMContentLoaded", function () {
            const requestSelect = document.getElementById("requestSelect");
            const productList = document.getElementById("productList").querySelector("tbody");
            const NgayXuatKho = document.getElementById("NgayXuatKho");

            requestSelect.addEventListener("change", function () {
                productList.innerHTML = "";

                // Lấy thông tin từ option được chọn
                const selectedOption = requestSelect.options[requestSelect.selectedIndex];
                const ngayXuatHang = selectedOption.getAttribute("data-ngayxuathang");
                const products = JSON.parse(selectedOption.getAttribute("data-products"));

                // Cập nhật ngày xuất kho
                NgayXuatKho.value = ngayXuatHang;

                // Hiển thị từng sản phẩm trong bảng
                products.forEach(product => {
                    const row = document.createElement("tr");

                    row.innerHTML = `
                                        <td><input class="form-control form-control-sm" type="text" value="${product.MaSanPham}" readonly></td>
                    <td><input class="form-control form-control-sm" type="text" value="${product.TenSanPham}" readonly></td>
                    <td><input class="form-control form-control-sm" type="number" value="${product.SoLuong}" readonly></td>
                    <td><input class="form-control form-control-sm" type="text" value="${product.DonVi}" readonly></td>
                `;

                    productList.appendChild(row);
                });
            });
        });
    </script>
</main>
</body>

</html>