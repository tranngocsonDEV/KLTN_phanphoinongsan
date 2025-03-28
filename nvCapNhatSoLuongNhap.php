<?php include("../php/header_heThong.php"); ?>

<?php include("../php/sidebar_heThong.php"); ?>

<?php include("../config/init.php"); ?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Xác nhận nhập kho">Xác nhận nhập kho
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Nhập kho</h3>
                    </div>
                    <?php

                    include("../php/thongBao.php");
                    ?>
                    <div class="card-body">
                        <div class="chitiet-row">
                            <form action="../php/nvCapNhatSoLuong_XuLy.php" method="POST">
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="maphieu">Mã phiếu</label>
                                        <select name="maphieu" id="requestSelect" class="form-select"
                                            aria-label="maphieu" required>
                                            <option selected disabled>Lựa chọn</option>
                                            <!-- Mục Phiếu nhập -->
                                            <optgroup label="Phiếu Nhập">
                                                <?php
                                                $query = "SELECT DISTINCT pn.MaPhieuNhap,  pn.NgayNhanHang, sp.Ten, ctpn.SoLuong,sp.MaSanPham, sp.DonVi
                                            FROM tbl_chitietphieunhap AS ctpn
                                            JOIN tbl_sanpham AS sp ON ctpn.MaSanPham = sp.MaSanPham
                                            JOIN tbl_phieunhap AS pn ON pn.MaPhieuNhap = ctpn.MaPhieuNhap
                                            WHERE pn.MaTrangThaiPhieu = 4";

                                                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                                                // Tạo mảng PHP để lưu các sản phẩm của từng Mã phiếu nhập
                                                $productsByRequest = [];
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $MaPhieuNhap = $row['MaPhieuNhap'];
                                                    $NgayNhanHang = $row['NgayNhanHang'];
                                                    $MaSanPham = $row['MaSanPham'];
                                                    $TenSanPham = $row['Ten'];
                                                    $SoLuong = $row['SoLuong'];
                                                    $DonVi = $row['DonVi'];

                                                    if (!isset($productsByRequest[$MaPhieuNhap])) {
                                                        $productsByRequest[$MaPhieuNhap] = [
                                                            "NgayNhanHang" => $NgayNhanHang,
                                                            "products" => []
                                                        ];
                                                    }
                                                    $productsByRequest[$MaPhieuNhap]["products"][] = [
                                                        "MaSanPham" => $MaSanPham,
                                                        "TenSanPham" => $TenSanPham,
                                                        "SoLuong" => $SoLuong,
                                                        "DonVi" => $DonVi
                                                    ];
                                                }

                                                // Tạo <option> và lưu dữ liệu vào dạng JSON trong mỗi <option>
                                                foreach ($productsByRequest as $MaPhieuNhap => $data) {
                                                    echo "<option value='$MaPhieuNhap' data-type='phieu_nhap' data-ngaynhanhang='{$data['NgayNhanHang']}' data-products='" . json_encode($data['products']) . "'>$MaPhieuNhap</option>";
                                                }
                                                ?>
                                            </optgroup>
                                            <!-- Yêu cầu đổi trả -->
                                            <optgroup label="Yêu Cầu Đổi Trả">
                                                <?php
                                                $queryBB = "SELECT DISTINCT bb.MaBienBan, pn.MaPhieuNhap, pn.NgayNhanHang, ct.MaSanPham, sp.Ten, ct.SoLuongThucTe, sp.DonVi
                                                FROM tbl_chitietbienban AS ct JOIN tbl_sanpham AS sp ON sp.MaSanPham = ct.MaSanPham JOIN tbl_bienban AS bb ON ct.MaBienBan = bb.MaBienBan 
                                                JOIN tbl_chitietphieunhap AS ctpn 
                                                ON ctpn.MaChiTietPhieuNhap = ct.MaChiTietPhieuNhap
                                                JOIN tbl_phieunhap AS pn
                                                ON pn.MaPhieuNhap=ctpn.MaPhieuNhap
                                                WHERE ct.MaChiTietPhieuXuat IS NULL AND pn.MaYeuCauDoiTra IS NOT NULL  AND pn.MaTrangThaiPhieu = '3'
                                               ";
                                                $resultBB = mysqli_query($conn, $queryBB) or die(mysqli_error($conn));

                                                $productsByRequestBB = [];
                                                while ($row = mysqli_fetch_assoc($resultBB)) {
                                                    $MaBienBan = $row['MaBienBan'];
                                                    $MaPhieuNhap = $row['MaPhieuNhap'];
                                                    $NgayNhanHang = $row['NgayNhanHang'];
                                                    $MaSanPham = $row['MaSanPham'];
                                                    $TenSanPham = $row['Ten'];
                                                    $SoLuong = $row['SoLuongThucTe'];
                                                    $DonVi = $row['DonVi'];

                                                    if (!isset($productsByRequestBB[$MaBienBan])) {
                                                        $productsByRequestBB[$MaBienBan] = [
                                                            "MaPhieuNhap" => $MaPhieuNhap,
                                                            "NgayNhanHang" => $NgayNhanHang,
                                                            "products" => []
                                                        ];
                                                    }
                                                    $productsByRequestBB[$MaBienBan]["products"][] = [
                                                        "MaSanPham" => $MaSanPham,
                                                        "TenSanPham" => $TenSanPham,
                                                        "SoLuong" => $SoLuong,
                                                        "DonVi" => $DonVi
                                                    ];
                                                }
                                                // Tạo <option> và lưu dữ liệu vào dạng JSON trong mỗi <option>
                                                foreach ($productsByRequestBB as $MaBienBan => $data) {
                                                    echo "<option value='$MaBienBan' data-type='doi_tra' data-maphieunhap='{$data['MaPhieuNhap']}' data-ngaynhanhang='{$data['NgayNhanHang']}' data-products='" . json_encode($data['products']) . "'>$MaBienBan</option>";
                                                }
                                                ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="NgayNhapKho">Ngày nhập kho</label>
                                        <input type="date" class="form-control" name="NgayNhapKho" id="NgayNhapKho"
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
                        <input type="hidden" id="MaPhieuNhap" name="MaPhieuNhap" value="">

                        <input type="hidden" name="productData" id="productData">

                        <div class="buttons">
                            <div class="d-grid gap-2 d-md-block">
                                <button type="submit" name="btn_confirm_request"
                                    class="tn btn-primary btn-lg btn_confirm_request">Xác
                                    nhận</button>
                                <a href="../view/nvCapNhatSoLuongNhap.php" class="btn btn-secondary btn-lg"
                                    tabindex="-1" role="button" aria-disabled="true">Quay lại</a>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Chọn phiếu nhập -->
    <script>
        document.getElementById('requestSelect').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const productsData = selectedOption.getAttribute('data-products');
            const type = selectedOption.dataset.type;
            const maphieunhap = selectedOption.dataset.maphieunhap;

            // Gán giá trị của data-products vào trường ẩn
            document.getElementById("MaPhieuNhap").value = maphieunhap;
            document.getElementById("type").value = type;
            document.getElementById('productData').value = productsData;
        });
        document.addEventListener("DOMContentLoaded", function () {
            const requestSelect = document.getElementById("requestSelect");
            const productList = document.getElementById("productList").querySelector("tbody");
            const NgayNhapKho = document.getElementById("NgayNhapKho");

            requestSelect.addEventListener("change", function () {
                productList.innerHTML = "";

                // Lấy thông tin từ option được chọn
                const selectedOption = requestSelect.options[requestSelect.selectedIndex];
                const ngayNhanHang = selectedOption.getAttribute("data-ngaynhanhang");
                const products = JSON.parse(selectedOption.getAttribute("data-products"));

                // Cập nhật ngày nhập kho
                NgayNhapKho.value = ngayNhanHang;

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