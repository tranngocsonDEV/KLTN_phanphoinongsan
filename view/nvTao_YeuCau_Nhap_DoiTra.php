<?php include("../php/header_heThong.php");
include("../php/sidebar_heThong.php");


?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Chi tiết">Chi tiết</div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Chi tiết yêu cầu</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row">

                                <div class="col-6">

                                    <dt class="col-sm-3">Mã phiếu nhập:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="MaPhieuNhap"
                                                placeholder="Mã phiếu nhập được tạo tự động" class="form-control"
                                                readonly>
                                        </div>
                                    </dd>

                                    <div class="form-group col-sm-9">
                                        <dt for="maphieu">Mã yêu cầu đổi trả:</dt>
                                        <select name="maphieu" id="requestSelect" class="form-select"
                                            aria-label="maphieu" required>
                                            <option selected disabled>Chọn yêu cầu đổi trả đã hoàn thành</option>
                                            <?php
                                            $query = "SELECT DISTINCT (yc.MaYeuCauDoiTra),ctdt.MaChiTiet, yc.NguoiLapDoiTra AS MaNguoiLapDoiTra, 
                                            u.Ten AS TenNguoiLapDoiTra,
                                            ctdt.MaSanPham, sp.Ten AS TenSanPham, sp.DonVi,ctdt.SoLuongDoiTra AS SoLuong, ctdt.ThanhTien, ctdt.TongTien, ctdt.DonGia, yc.MaKhachHang, 
                                            kh.Ten AS TenKhachHang, kh.DiaChi, kh.SoDienThoai, kh.Email, kh.NganhNgheKinhDoanh
                                            FROM tbl_chitietyeucaudoitra AS ctdt
                                            JOIN tbl_yeucaudoitra AS yc
                                            ON yc.MaYeuCauDoiTra=ctdt.MaYeuCauDoiTra
                                            JOIN tbl_sanpham AS sp ON ctdt.MaSanPham = sp.MaSanPham
                                            JOIN tbl_khachhang AS kh ON kh.MaKhachHang = yc.MaKhachHang
                                            JOIN tbl_user AS u
                                            ON u.IDNhanVien = yc.NguoiLapDoiTra
                                            WHERE yc.MaTrangThaiPhieu = '13'
                                            ORDER BY yc.MaYeuCauDoiTra ASC

                                                ";

                                            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                                            // Tạo mảng PHP để lưu các sản phẩm của từng Mã phiếu nhập
                                            $productsByRequest = [];
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $MaYeuCauDoiTra = $row['MaYeuCauDoiTra'];
                                                $MaChiTiet = $row['MaChiTiet'];
                                                $MaNguoiLapDoiTra = $row['MaNguoiLapDoiTra'];
                                                $TenNguoiLapDoiTra = $row['TenNguoiLapDoiTra'];
                                                $MaKhachHang = $row['MaKhachHang'];
                                                $TenKhachHang = $row['TenKhachHang'];
                                                $DiaChi = $row['DiaChi'];
                                                $SoDienThoai = $row['SoDienThoai'];
                                                $Email = $row['Email'];
                                                $NganhNgheKinhDoanh = $row['NganhNgheKinhDoanh'];
                                                $MaSanPham = $row['MaSanPham'];
                                                $TenSanPham = $row['TenSanPham'];
                                                $SoLuong = $row['SoLuong'];
                                                $DonVi = $row['DonVi'];
                                                $DonGiaBan = $row['DonGia'];
                                                $ThanhTien = $row['ThanhTien'];
                                                $TongTien = $row['TongTien'];

                                                if (!isset($productsByRequest[$MaYeuCauDoiTra])) {
                                                    $productsByRequest[$MaYeuCauDoiTra] = [
                                                        "MaNguoiLapDoiTra" => $MaNguoiLapDoiTra,
                                                        "TenNguoiLapDoiTra" => $TenNguoiLapDoiTra,
                                                        "MaKhachHang" => $MaKhachHang,
                                                        "TenKhachHang" => $TenKhachHang,
                                                        "DiaChi" => $DiaChi,
                                                        "SoDienThoai" => $SoDienThoai,
                                                        "Email" => $Email,
                                                        "NganhNgheKinhDoanh" => $NganhNgheKinhDoanh,
                                                        "products" => []
                                                    ];
                                                }
                                                $productsByRequest[$MaYeuCauDoiTra]["products"][] = [
                                                    "MaChiTiet" => $MaChiTiet,
                                                    "MaSanPham" => $MaSanPham,
                                                    "TenSanPham" => $TenSanPham,
                                                    "SoLuong" => $SoLuong,
                                                    "DonVi" => $DonVi,
                                                    "DonGiaBan" => $DonGiaBan,
                                                    "ThanhTien" => $ThanhTien,
                                                    "TongTien" => $TongTien

                                                ];
                                            }

                                            // Kiểm tra nếu mảng productsByRequest có dữ liệu
                                            if (empty($productsByRequest)) {
                                                echo "<option disabled>Không có dữ liệu</option>";
                                            } else {
                                                // Lấy giá trị MaYeuCauDoiTra từ URL nếu có
                                                $selectedMaPhieu = isset($_GET['MaYeuCauDoiTra']) ? $_GET['MaYeuCauDoiTra'] : NULL;

                                                // Duyệt mảng và hiển thị các options, chọn tự động nếu trùng với MaYeuCauDoiTra
                                                foreach ($productsByRequest as $MaYeuCauDoiTra => $data) {
                                                    $selected = ($MaYeuCauDoiTra == $selectedMaPhieu) ? 'selected' : '';
                                                    echo "<option value='$MaYeuCauDoiTra' $selected data-tennhanvientaophieudoitra='{$data['TenNguoiLapDoiTra']}' data-makh='{$data['MaKhachHang']}' data-tenkh='{$data['TenKhachHang']}' data-diachi='{$data['DiaChi']}' data-sodienthoai='{$data['SoDienThoai']}' data-email='{$data['Email']}' data-nganhnghekinhdoanh='{$data['NganhNgheKinhDoanh']}' data-products='" . json_encode($data['products']) . "'>$MaYeuCauDoiTra</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <dt class="col-sm-3">Người lập yêu cầu đổi trả:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="NguoiLapPhieu" id="NguoiLapPhieu" placeholder=""
                                                class="form-control" disabled>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Ghi chú:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <textarea name="GhiChu" id="GhiChu" rows="4" cols="60"></textarea>
                                        </div>
                                    </dd>
                                </div>
                                <div class="col-6">
                                    <dt class="col-sm-4">Người lập phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" value="<?= $_SESSION['ThongTinDangNhap']['Ten']; ?>"
                                                placeholder="Lấy session của người tạo" class="form-control" disabled>

                                            <input type="hidden" name="NguoiLapDoiTra"
                                                value="<?= $_SESSION['ThongTinDangNhap']['User_id']; ?>" required>
                                        </div>
                                    </dd>

                                    <dt class="col-sm-3">Ngày lập phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayLapPhieu" id="NgayLapPhieu"
                                                class="form-control" required>
                                        </div>

                                    </dd>

                                    <dt class="col-sm-3">Ngày nhận hàng:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayNhanHang" id="NgayNhanHang"
                                                class="form-control" required>
                                        </div>

                                    </dd>
                                    <div class="ThongTinNCC" style="display: none;">
                                        <dt class="col-sm-3">Mã KH:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="MaKH" placeholder="Mã của khách hàng"
                                                    class="form-control" readonly>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Tên khách hàng:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="TenKH" placeholder="Nhập tên khách hàng"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Địa chỉ :</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="DiaChi" placeholder="Nhập địa chỉ khách hàng"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Số điện thoại:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="number" name="SoDienThoai"
                                                    placeholder="Nhập số diện thoại khách hàng" class="form-control"
                                                    minlength="9" maxlength="11" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Email:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="email" name="Email" placeholder="Nhập email khách hàng"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>

                                        <dt class="col-sm-3">Ngành nghề kinh doanh:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="NganhNgheKinhDoanh"
                                                    placeholder="Nhập ngành nghề kinh doanh" class="form-control"
                                                    disabled>
                                            </div>
                                        </dd>
                                    </div>
                                </div>
                            </div>
                            <dt class="col-sm-3 mb-4">Danh sách yêu cầu:</dt>

                            <table class="table table-striped table-bordered table-responsive mb-4" id="productList">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng yêu cầu</th>
                                        <th>Đơn vị</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Tổng tiền:</strong></td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" id="tfootTotal"
                                                value="0.00" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                                <input type="hidden" name="productData" id="productData">

                            </table>

                            <div class="buttons">
                                <div class="d-grid gap-2 d-md-block">

                                    <button type="submit" name="btn_confirm_report" class="btn btn-success btn-lg">Lập
                                        phiếu</button>
                                    <a href="./nvYeuCauDoiTra.php" class="btn btn-secondary btn-lg" tabindex="-1"
                                        role="button" aria-disabled="true">Quay lại</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const requestSelect = document.getElementById("requestSelect");
            const productList = document.getElementById("productList").querySelector("tbody");
            const NguoiLapPhieu = document.getElementById("NguoiLapPhieu");
            const productData = document.getElementById("productData"); // Trường ẩn lưu dữ liệu sản phẩm
            const tfootTotal = document.getElementById("tfootTotal"); // Lấy ô input Tổng tiền

            // Lắng nghe sự kiện khi chọn phiếu nhập
            requestSelect.addEventListener("change", function () {
                productList.innerHTML = "";

                // Lấy thông tin từ option được chọn
                const selectedOption = requestSelect.options[requestSelect.selectedIndex];
                const NguoiLapPhieuSelect = selectedOption.getAttribute("data-tennhanvientaophieudoitra");
                const products = JSON.parse(selectedOption.getAttribute("data-products"));

                const supplierData = {
                    maKH: selectedOption.getAttribute('data-makh'),
                    tenKH: selectedOption.getAttribute('data-tenkh'),
                    diaChi: selectedOption.getAttribute('data-diachi'),
                    soDienThoai: selectedOption.getAttribute('data-sodienthoai'),
                    email: selectedOption.getAttribute('data-email'),
                    nganhNgheKinhDoanh: selectedOption.getAttribute('data-nganhnghekinhdoanh')
                };


                // Hiển thị thông tin trong ThongTinNCC
                const thongTinNCC = document.querySelector('.ThongTinNCC');
                thongTinNCC.style.display = 'block';

                // Cập nhật các trường input
                thongTinNCC.querySelector('input[name="MaKH"]').value = supplierData.maKH;
                thongTinNCC.querySelector('input[name="TenKH"]').value = supplierData.tenKH;
                thongTinNCC.querySelector('input[name="DiaChi"]').value = supplierData.diaChi;
                thongTinNCC.querySelector('input[name="SoDienThoai"]').value = supplierData.soDienThoai;
                thongTinNCC.querySelector('input[name="Email"]').value = supplierData.email;
                thongTinNCC.querySelector('input[name="NganhNgheKinhDoanh"]').value = supplierData.nganhNgheKinhDoanh;
                // Cập nhật ngày nhập kho
                NguoiLapPhieu.value = NguoiLapPhieuSelect;

                // Cập nhật dữ liệu sản phẩm vào trường ẩn
                productData.value = JSON.stringify(products); // Cập nhật lại dữ liệu sản phẩm

                let TongTien = 0; // Tổng tiền

                products.forEach((product, index) => {
                    const row = document.createElement("tr");

                    row.innerHTML = `
                    <td><input class="form-control form-control-sm" type="text" value="${product.TenSanPham}" readonly></td>
                    <td><input class="form-control form-control-sm" type="number" value="${product.SoLuong}" readonly></td>
                    <td><input class="form-control form-control-sm" type="text" value="${product.DonVi}" readonly></td>
                    <td><input class="form-control form-control-sm" type="number" value="${product.DonGiaBan}" readonly></td>
                    <td><input class="form-control form-control-sm" type="number" value="${product.ThanhTien}" readonly></td>
                `;
                    productList.appendChild(row);

                    TongTien += parseFloat(product.ThanhTien || 0); // Đảm bảo giá trị không bị NaN
                });
                tfootTotal.value = TongTien.toFixed(2);


            });

            // Kích hoạt sự kiện change nếu MaYeuCauDoiTra đã được chọn từ URL
            const selectedMaPhieu = new URLSearchParams(window.location.search).get('MaYeuCauDoiTra');
            if (selectedMaPhieu) {
                const options = requestSelect.querySelectorAll('option');
                options.forEach(option => {
                    if (option.value === selectedMaPhieu) {
                        option.selected = true;
                    }
                });
                // Kích hoạt sự kiện change sau khi chọn
                requestSelect.dispatchEvent(new Event('change'));
            }
        });

        // Đảm bảo rằng productData được truyền khi form submit
        document.getElementById("denyForm").addEventListener("submit", function (event) {
            const productDataValue = document.getElementById("productData").value;
            if (productDataValue) {
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "productData";
                hiddenInput.value = productDataValue;
                this.appendChild(hiddenInput); // Thêm vào form trước khi submit
            }
        });
    </script>


    <?php
    ob_start();
    include("../config/init.php");
    include("../php/thongBao.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_confirm_report'])) {

        $conn->begin_transaction();

        try {
            $MaPhieuNhap = NULL;
            $MaLoaiPhieu = '4';
            $MaTrangThaiPhieu = '1';
            $MaNhaCungCap = NULL;
            $MaPhieuDoiTra = $_POST['maphieu'];
            $GhiChuDoiTra = $_POST['GhiChu'];
            $NguoiLapDoiTra = $_POST['NguoiLapDoiTra'];
            $NgayLapPhieu = $_POST['NgayLapPhieu'];
            $NgayDatHang = date("Y-m-d");
            $NgayNhanHang = $_POST['NgayNhanHang'];
            $MaKH = $_POST['MaKH'];
            $products = json_decode($_POST['productData'], true); // Giải mã MaSanPham thành mảng
            $TongSoLoaiSanPham = count(array_unique(array_column( $products,  'MaSanPham')));
            $MaTrangThaiTrongDoiTra = '22';
            // Kiểm tra xem NgayLapDoiTra có được chọn không
            if (!isset($_POST['NgayLapPhieu']) || empty($_POST['NgayLapPhieu'])) {
                $_SESSION['errorMessages'] = "Vui lòng chọn ngày lập!";
                echo "<script>
                window.location.href = 'nvTao_YeuCau_Nhap_DoiTra.php';
                </script>";
                exit;
            }
            if (!isset($_POST['NgayNhanHang']) || empty($_POST['NgayNhanHang'])) {
                $_SESSION['errorMessages'] = "Vui lòng chọn ngày nhận!";
                echo "<script>
                window.location.href = 'nvTao_YeuCau_Nhap_DoiTra.php';
                </script>";
                exit;
            }
            // Kiểm tra xem MaSP có được chọn không
            if (!isset($_POST['maphieu']) || empty($_POST['maphieu'])) {
                $_SESSION['errorMessages'] = "Vui lòng chọn mã phiếu!";
                echo "<script>
            window.location.href = 'nvTao_YeuCau_Nhap_DoiTra.php';
            </script>";
                exit;
            }
            if (!is_array($products)) {
                throw new Exception("Dữ liệu sản phẩm không hợp lệ.");
            }



            $products = json_decode($_POST['productData'], true); // Giải mã JSON thành mảng
            $TongSoLoaiSanPham = count(array_unique(array_column($products, 'MaSanPham')));


            // Insert phiếu nhập
            $sql1 = "INSERT INTO `tbl_phieunhap`
            (`MaYeuCauDoiTra`, `MaLoaiPhieu`, `MaTrangThaiPhieu`,  `NgayLapPhieu`, `NgayDatHang`, `NgayNhanHang`, `TongSoLoaiSanPham`, `GhiChu`) 
             VALUES 
            ( '$MaPhieuDoiTra', '$MaLoaiPhieu', ' $MaTrangThaiPhieu','$NgayLapPhieu','$NgayDatHang' ,'$NgayNhanHang' ,'$TongSoLoaiSanPham' ,'$GhiChuDoiTra')";
            if (!$conn->query($sql1)) {
                throw new Exception("Không thể thêm vào cơ sở dữ liệu: " . $conn->error);
            }
            $MaPhieuNhap = $conn->insert_id;

            $stmt = $conn->prepare("INSERT INTO `tbl_chitietphieunhap`
            (`MaChiTietPhieuNhap`, `MaPhieuNhap`, `MaSanPham`, `SoLuong`, `DonGiaNhap`, `ThanhTien`, `TongTien`)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissddd", $MaChiTietPhieuNhap, $MaPhieuNhap, $MaSanPham, $SoLuong, $DonGiaBan, $ThanhTien, $TongTien);

            foreach ($products as $key => $product) {
                $MaChiTietPhieuNhap = NULL;
                $MaSanPham = $product['MaSanPham'];
                $SoLuong = $product['SoLuong'];
                $DonGiaBan = $product['DonGiaBan'];
                $ThanhTien = $product['ThanhTien'];
                $TongTien = $product['TongTien'];




                // Thực thi câu lệnh SQL
                if (!$stmt->execute()) {
                    echo "Lỗi: " . $stmt->error;
                }
            }
            // Insert into tbl_yeucaudoitra 
            $stmtNhanVien = $conn->prepare("UPDATE tbl_yeucaudoitra SET MaTrangThaiPhieu = ? WHERE MaYeuCauDoiTra = ?");
            $stmtNhanVien->bind_param("ii", $MaTrangThaiTrongDoiTra, $MaPhieuDoiTra);
            if (!$stmtNhanVien->execute()) {
                throw new Exception("Không thể chèn vào tbl_yeucaudoitra: " . $stmtNhanVien->error);
            }


            // Insert into tbl_nhanvienkho_tao_phieu_nhap
            $stmtNhanVien = $conn->prepare("INSERT INTO tbl_nhanvienkho_taophieu_nhap (MaPhieuNhap, IDNhanVien) VALUES (?, ?)");
            $stmtNhanVien->bind_param("si", $MaPhieuNhap, $NguoiLapDoiTra);
            if (!$stmtNhanVien->execute()) {
                throw new Exception("Không thể chèn vào tbl_nhanvienkho_tao_phieu_nhap: " . $stmtNhanVien->error);
            }
            // Commit giao dịch
            $conn->commit();
            $_SESSION['message'] = "Tạo phiếu nhập cho đơn đổi trả thành công!";
            echo "<script>
                window.location.href = 'nvYeuCauDoiTra_Nhap.php';
                </script>";
            exit;

        } catch (Exception $e) {
            $conn->rollback();
            echo "Lỗi khi tạo phiếu nhập cho đơn đổi trả: " . $e->getMessage();
        }
    }
    ?>

</main>
</body>

</html>