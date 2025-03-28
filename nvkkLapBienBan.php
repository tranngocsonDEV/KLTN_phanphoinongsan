<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>

<?php
include("../config/init.php");
include("../php/thongBao.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['ThongTinDangNhap']) || !isset($_SESSION['MaVaiTro'])) {
    $_SESSION['errorMessages'] = "Bạn phải đăng nhập để truy cập trang này!";
    header("Location: login.php");
    exit;
}

// Kiểm tra quyền truy cập: chỉ nhân viên kiểm kêkê (MaVaiTro = 3) mới được truy cập
if ($_SESSION['MaVaiTro'] != '3') {
    $_SESSION['errorMessages'] = "Bạn không có quyền truy cập trang này!";
    header("Location: login.php");
    exit;
}

?>
<?php include("../php/header_heThong.php");
include("../php/sidebar_heThong.php");


?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Biên bản">Biên bản</div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Chi tiết biên bản</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <dl class="row">

                                <div class="col-6">

                                    <dt class="col-sm-3">Mã biên bản kiểm kê:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="MaBienBan" placeholder="" class="form-control"
                                                readonly>
                                        </div>
                                    </dd>

                                    <div class="form-group col-sm-9">
                                        <label for="maphieu">Mã phiếu</label>
                                        <select name="maphieu" id="requestSelect" class="form-select"
                                            aria-label="maphieu" required>
                                            <option selected disabled>Lựa chọn</option>
                                            <?php
                                            $query = "SELECT DISTINCT(pn.MaPhieuNhap), ctpn.MaChiTietPhieuNhap, nvk.IDNhanVien, u.Ten AS TenNhanVienTaoPhieu , sp.Ten AS TenSanPham, ctpn.SoLuong,sp.MaSanPham, sp.DonVi
    FROM tbl_chitietphieunhap AS ctpn
    JOIN tbl_sanpham AS sp ON ctpn.MaSanPham = sp.MaSanPham
    JOIN tbl_phieunhap AS pn ON pn.MaPhieuNhap = ctpn.MaPhieuNhap
    JOIN tbl_nhanvienkho_taophieu_nhap AS nvk
    ON nvk.MaPhieuNhap = pn.MaPhieuNhap
    JOIN tbl_user AS u
    ON u.IDNhanVien = nvk.IDNhanVien
    WHERE pn.MaTrangThaiPhieu = 1
    ORDER BY pn.MaPhieuNhap ASC";

                                            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                                            // Tạo mảng PHP để lưu các sản phẩm của từng Mã phiếu nhập
                                            $productsByRequest = [];
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $MaPhieuNhap = $row['MaPhieuNhap'];
                                                $MaChiTietPhieuNhap = $row['MaChiTietPhieuNhap'];
                                                $IDNhanVien = $row['IDNhanVien'];
                                                $TenNhanVienTaoPhieu = $row['TenNhanVienTaoPhieu'];
                                                $MaSanPham = $row['MaSanPham'];
                                                $TenSanPham = $row['TenSanPham'];
                                                $SoLuong = $row['SoLuong'];
                                                $DonVi = $row['DonVi'];

                                                if (!isset($productsByRequest[$MaPhieuNhap])) {
                                                    $productsByRequest[$MaPhieuNhap] = [
                                                        "IDNhanVien" => $IDNhanVien,
                                                        "TenNhanVienTaoPhieu" => $TenNhanVienTaoPhieu,
                                                        "products" => []
                                                    ];
                                                }
                                                $productsByRequest[$MaPhieuNhap]["products"][] = [
                                                    "MaChiTietPhieuNhap" => $MaChiTietPhieuNhap,
                                                    "MaSanPham" => $MaSanPham,
                                                    "TenSanPham" => $TenSanPham,
                                                    "SoLuong" => $SoLuong,
                                                    "DonVi" => $DonVi
                                                ];
                                            }

                                            // Kiểm tra nếu mảng productsByRequest có dữ liệu
                                            if (empty($productsByRequest)) {
                                                echo "<option disabled>Không có dữ liệu</option>";
                                            } else {
                                                // Lấy giá trị MaPhieuNhapKho từ URL nếu có
                                                $selectedMaPhieu = isset($_GET['MaPhieuNhapKho']) ? $_GET['MaPhieuNhapKho'] : '';

                                                // Duyệt mảng và hiển thị các options, chọn tự động nếu trùng với MaPhieuNhapKho
                                                foreach ($productsByRequest as $MaPhieuNhap => $data) {
                                                    $selected = ($MaPhieuNhap == $selectedMaPhieu) ? 'selected' : '';
                                                    echo "<option value='$MaPhieuNhap' $selected data-tennhanvientaophieu='{$data['TenNhanVienTaoPhieu']}' data-products='" . json_encode($data['products']) . "'>$MaPhieuNhap</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <dt class="col-sm-3">Người lập phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="NguoiLapPhieu" id="NguoiLapPhieu" placeholder=""
                                                class="form-control" disabled>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Lý do:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <textarea name="LyDoLapBienBan" id="LyDoLapBienBan" rows="4"
                                                cols="60"></textarea>
                                        </div>
                                    </dd>
                                </div>
                                <div class="col-6">
                                    <dt class="col-sm-3">Người lập biên bản:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" value="<?= $_SESSION['ThongTinDangNhap']['Ten']; ?>"
                                                placeholder="Lấy session của người tạo" class="form-control" disabled>

                                            <input type="hidden" name="NguoiLapBienBan"
                                                value="<?= $_SESSION['ThongTinDangNhap']['User_id']; ?>" required>
                                        </div>
                                    </dd>

                                    <dt class="col-sm-3">Ngày lập biên bản:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayLapBienBan" id="NgayLapBienBan"
                                                class="form-control" required>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Kết quả kiểm tra:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="TrangThaiBienBan" id="TrangThaiBienBan"
                                                class="form-control" placeholder="ĐẠT hoặc KHÔNG ĐẠT" value="KHÔNG ĐẠT"
                                                readonly required>
                                        </div>
                                    </dd>

                                </div>
                            </dl>
                            <dt class="col-sm-3 mb-4">Danh sách yêu cầu:</dt>

                            <table class="table table-striped table-bordered table-responsive mb-4" id="productList">
                                <thead>
                                    <tr>
                                        <th>Mã sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng yêu cầu</th>
                                        <th>Số lượng thực tế</th>
                                        <th>Đơn vị</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <input type="hidden" name="productData" id="productData">

                            </table>

                            <div class="buttons">
                                <div class="d-grid gap-2 d-md-block">

                                    <button type="submit" name="btn_confirm_report" class="btn btn-success btn-lg">Lập
                                        phiếu</button>
                                    <a href="./nvkkPhieuBienBan.php" class="btn btn-secondary btn-lg" tabindex="-1"
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

            // Lắng nghe sự kiện khi chọn phiếu nhập
            requestSelect.addEventListener("change", function () {
                productList.innerHTML = "";

                // Lấy thông tin từ option được chọn
                const selectedOption = requestSelect.options[requestSelect.selectedIndex];
                const NguoiLapPhieuSelect = selectedOption.getAttribute("data-tennhanvientaophieu");
                const products = JSON.parse(selectedOption.getAttribute("data-products"));

                // Cập nhật ngày nhập kho
                NguoiLapPhieu.value = NguoiLapPhieuSelect;

                // Cập nhật dữ liệu sản phẩm vào trường ẩn
                productData.value = JSON.stringify(products); // Cập nhật lại dữ liệu sản phẩm

                // Hiển thị từng sản phẩm trong bảng
                products.forEach((product, index) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                                        <td><input class="form-control form-control-sm" type="text" value="${product.MaSanPham}" readonly></td>
                    <td><input class="form-control form-control-sm" type="text" value="${product.TenSanPham}" readonly></td>
                    <td><input class="form-control form-control-sm" type="number" value="${product.SoLuong}" readonly></td>
                    <td><input class="form-control form-control-sm" type="number" name="SoLuongThucTe[]" placeholder="Nhập số lượng thực tế" required></td>
                    <td><input class="form-control form-control-sm" type="text" value="${product.DonVi}" readonly></td>
                `;

                    productList.appendChild(row);
                });
            });

            // Kích hoạt sự kiện change nếu MaPhieuNhapKho đã được chọn từ URL
            const selectedMaPhieu = new URLSearchParams(window.location.search).get('MaPhieuNhapKho');
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
            $MaPhieu = $_POST['maphieu'];
            $LyDoLapBienBan = $_POST['LyDoLapBienBan'];
            $NguoiLapBienBan = $_POST['NguoiLapBienBan'];
            $NgayLapBienBan = $_POST['NgayLapBienBan'];
            $TinhTrangBienBan = $_POST['TrangThaiBienBan'];
            $NguoiLapBienBan = $_POST['NguoiLapBienBan'];
            $products = json_decode($_POST['productData'], true);
            $SoLuongThucTe = $_POST['SoLuongThucTe'];





            // Insert biên bản
            $sql1 = "INSERT INTO tbl_bienban(NgayLapBienBan, LyDo, NguoiLapBienBan, TinhTrangChatLuong) 
                     VALUES ('$NgayLapBienBan', '$LyDoLapBienBan', '$NguoiLapBienBan', 'KhongDat')";
            if (!$conn->query($sql1)) {
                throw new Exception("Không thể thêm vào cơ sở dữ liệu: " . $conn->error);
            }
            $MaBienBan = $conn->insert_id;

            // Chuẩn bị câu lệnh insert vào tbl_chitietbienban
            $stmt = $conn->prepare("INSERT INTO tbl_chitietbienban 
                (MaChiTietBienBan, MaChiTietPhieuXuat, MaChiTietPhieuNhap, MaBienBan, MaSanPham, SoLuongTheoYeuCau, SoLuongThucTe) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisiiid", $MaChiTietBienBan, $MaChiTietPhieuXuat, $MaChiTietPhieuNhap, $MaBienBan, $MaSanPham, $SoLuongYeuCau, $SoLuongThucTeValue);

            // Duyệt qua danh sách sản phẩm
            foreach ($products as $key => $product) {
                $MaChiTietBienBan = '';
                $MaChiTietPhieuXuat = NULL;
                $MaChiTietPhieuNhap = $product['MaChiTietPhieuNhap'];
                $MaSanPham = $product['MaSanPham'];
                $SoLuongYeuCau = $product['SoLuong'];
                $SoLuongThucTeValue = $SoLuongThucTe[$key];


                // Kiểm tra ràng buộc: Số lượng thực tế không được lớn hơn số lượng yêu cầu
                if ($SoLuongThucTeValue > $SoLuongYeuCau) {
                    $_SESSION['errorMessages'] = "Số lượng thực tế của sản phẩm mã $MaSanPham vượt quá số lượng yêu cầu ($SoLuongYeuCau).";
                    echo "<script>
        window.history.back();
                          </script>";
                    exit;
                }

                // Thực thi câu lệnh SQL
                if (!$stmt->execute()) {
                    echo "Lỗi: " . $stmt->error;
                }
            }

            // Cập nhật trạng thái phiếu nhập
            $sql = "UPDATE tbl_phieunhap SET MaTrangThaiPhieu = 2 WHERE MaPhieuNhap = '$MaPhieu'";
            if (!$conn->query($sql)) {
                throw new Exception("Không thể cập nhật trạng thái của phiếu nhập: " . $conn->error);
            }

            // Commit giao dịch
            $conn->commit();
            $_SESSION['message'] = "Lập biên bản thành công!";
            echo "<script>
                window.location.href = 'nvkkPhieuBienBan.php';
                </script>";
            exit;

        } catch (Exception $e) {
            $conn->rollback();
            echo "Lỗi khi tạo biên bản: " . $e->getMessage();
        }
    }
    ?>

</main>
</body>

</html>