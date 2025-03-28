<?php include("../php/header_heThong.php");
include("../php/sidebar_heThong.php");

?>
<?php
if (isset($_GET["MaPhieuNhapKho"])) {
    $MaPhieuNhapKho = $_GET["MaPhieuNhapKho"];
}
?>

<?php


$sql = "SELECT tbl_phieunhap.MaPhieuNhap AS MaPhieuNhapKho, lp.Ten AS Ten, nvk.IDNhanVien AS IDNhanVienKho, u.Ten AS NhanVienKho,
                      NgayLapPhieu, NgayDatHang, NgayNhanHang, TongSoLoaiSanPham, tbl_a_trangthaiphieuyeucau.Ten AS TenTrangThai ,GhiChu,
                      ncc.MaNhaCungCap AS MaNhaCungCap, 
                      ncc.Ten AS TenNhaCungCap, ncc.DiaChi, ncc.SoDienThoai, ncc.Email, ncc.NganhHangCungCap, ncc.SanPhamCungCap 
                      FROM tbl_phieunhap 
                      JOIN tbl_a_trangthaiphieuyeucau ON tbl_phieunhap.MaTrangThaiPhieu = tbl_a_trangthaiphieuyeucau.MaTrangThaiPhieu
                      JOIN tbl_a_loaiphieu AS lp ON tbl_phieunhap.MaLoaiPhieu = lp.MaLoaiPhieu
                      JOIN tbl_nhanvienkho_taophieu_nhap AS nvk ON tbl_phieunhap.MaPhieuNhap = nvk.MaPhieuNhap
                      JOIN tbl_nhacungcap AS ncc
                      ON tbl_phieunhap.MaNhaCungCap = ncc.MaNhaCungCap
                      JOIN tbl_user AS u 
                      ON nvk.IDNhanVien = u.IDNhanVien
                      WHERE tbl_phieunhap.MaPhieuNhap= '$MaPhieuNhapKho'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);

?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Chi tiết">Chi tiết</div>
        </div>
        <div class="row">
            <div class="message_show">

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Phiếu yêu cầu nhập kho</h3>
                    </div>
                    <form action="" method="POST">
                        <div class="card-body">
                            <?php
                            include("../php/thongBao.php");
                            ?>


                            <dl class="row">
                                <div class="col-6">
                                    <dt class="col-sm-3">Mã phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="MaPhieu" placeholder=""
                                                value="<?php echo $row['MaPhieuNhapKho']; ?>" class="form-control"
                                                readonly>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Tên phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="TenPhieu" value="<?php echo $row['Ten']; ?>"
                                                class="form-control" readonly>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Người lập:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" value="<?php echo $row['NhanVienKho']; ?>"
                                                placeholder="Lấy session của người tạo" class="form-control" disabled>

                                            <input type="hidden" name="NguoiLap"
                                                value="<?php echo $row['IDNhanVienKho']; ?>" required>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Ghi chú:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="NoiDung" value="<?php echo $row['GhiChu']; ?>"
                                                class="form-control" required>

                                        </div>
                                    </dd>
                                </div>
                                <div class="col-6">
                                    <dt class="col-sm-3">Ngày lập phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayLapPhieu"
                                                value="<?php echo $row['NgayLapPhieu']; ?>" class="form-control"
                                                required>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Ngày đặt hàng:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayDatHang"
                                                value="<?php echo $row['NgayDatHang']; ?>" class="form-control"
                                                required>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Ngày nhận hàng:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayNhanHang"
                                                value="<?php echo $row['NgayNhanHang']; ?>" class="form-control"
                                                required>
                                        </div>
                                    </dd>

                                    <dd class="col-sm-12 d-flex">
                                        <div class="col-sm-9 ">
                                            <div class="input-group mb-3">
                                                <select id="supplierSelect" class="form-select col-sm-9 supplierSelect"
                                                    aria-label="supplierSelect" required>
                                                    <option selected disabled>Chọn nhà cung cấp mới</option>
                                                    <?php
                                                    include("../php/connect.php");

                                                    $query = "SELECT * FROM `tbl_nhacungcap` ";

                                                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                                    if (mysqli_num_rows(result: $result) > 0) {
                                                        while ($row = mysqli_fetch_assoc(result: $result)) {
                                                            ?>
                                                            <option value="<?php echo $row['MaNhaCungCap'] ?>"
                                                                data-mancc="<?php echo $row['MaNhaCungCap'] ?>"
                                                                data-tenncc="<?php echo $row['Ten'] ?>"
                                                                data-diachi="<?php echo $row['DiaChi'] ?>"
                                                                data-sodienthoai="<?php echo $row['SoDienThoai'] ?>"
                                                                data-email="<?php echo $row['Email'] ?>"
                                                                data-nganhhangcungcap="<?php echo $row['NganhHangCungCap'] ?>"
                                                                data-sanphamcungcap="<?php echo $row['SanPhamCungCap'] ?>">
                                                                <?php echo "<p><strong>Mã NCC:</strong> " . $row['MaNhaCungCap'] . "; <strong>Nhà cung cấp:</strong> " . $row['Ten'] . "</p>"; ?>

                                                            </option>
                                                        <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                    </dd>
                                    <div class="ThongTinNCC" style="display: block;">
                                        <?php
                                        $sql = "SELECT tbl_phieunhap.MaPhieuNhap AS MaPhieuNhapKho, lp.Ten AS Ten, nvk.IDNhanVien AS NhanVienKho, 
                                        NgayLapPhieu, NgayDatHang, NgayNhanHang, TongSoLoaiSanPham, tbl_a_trangthaiphieuyeucau.Ten AS TenTrangThai ,GhiChu,
                                        ncc.MaNhaCungCap AS MaNhaCungCap, 
                                        ncc.Ten AS TenNhaCungCap, ncc.DiaChi, ncc.SoDienThoai, ncc.Email, ncc.NganhHangCungCap, ncc.SanPhamCungCap 
                                        FROM tbl_phieunhap 
                                        JOIN tbl_a_trangthaiphieuyeucau ON tbl_phieunhap.MaTrangThaiPhieu = tbl_a_trangthaiphieuyeucau.MaTrangThaiPhieu
                                        JOIN tbl_a_loaiphieu AS lp ON tbl_phieunhap.MaLoaiPhieu = lp.MaLoaiPhieu
                                        JOIN tbl_nhanvienkho_taophieu_nhap AS nvk ON tbl_phieunhap.MaPhieuNhap = nvk.MaPhieuNhap
                                        JOIN tbl_nhacungcap AS ncc
                                        ON tbl_phieunhap.MaNhaCungCap = ncc.MaNhaCungCap 
                                        WHERE tbl_phieunhap.MaPhieuNhap= '$MaPhieuNhapKho'";
                                        $result = $conn->query($sql);
                                        $row = mysqli_fetch_array($result);


                                        ?>
                                        <dt class="col-sm-3">Mã NCC:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="MaNCC" placeholder="Mã của nhà cung cấp"
                                                    value="<?php echo isset($row['MaNhaCungCap']) ? $row['MaNhaCungCap'] : ''; ?>"
                                                    class="form-control" readonly>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Nhà cung cấp:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="TenNCC"
                                                    value="<?php echo isset($row['TenNhaCungCap']) ? $row['TenNhaCungCap'] : ''; ?>"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Địa chỉ :</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="DiaChi"
                                                    value="<?php echo isset($row['DiaChi']) ? $row['DiaChi'] : ''; ?>"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Số điện thoại:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="number" name="SoDienThoai"
                                                    placeholder="Nhập số diện thoại nhà cung cấp"
                                                    value="<?php echo isset($row['SoDienThoai']) ? $row['SoDienThoai'] : ''; ?>"
                                                    class="form-control" minlength="9" maxlength="11" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Email:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="email" name="Email" placeholder="Nhập email nhà cung cấp"
                                                    value="<?php echo isset($row['Email']) ? $row['Email'] : ''; ?>"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Ngành hàng cung cấp:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="NganhHangCungCap"
                                                    placeholder="Nhập ngành hàng cung cấp"
                                                    value="<?php echo isset($row['NganhHangCungCap']) ? $row['NganhHangCungCap'] : ''; ?>"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Sản phẩm cung cấp:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="SanPhamCungCap"
                                                    placeholder="Nhập sản phẩm cung cấp"
                                                    value="<?php echo isset($row['SanPhamCungCap']) ? $row['SanPhamCungCap'] : ''; ?>"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                    </div>
                                </div>

                            </dl>

                            <dt class="col-sm-3">Danh sách yêu cầu:</dt>
                            <button id="themspnhap" type="button" class="btn btn-primary" onclick="addProductRow()"
                                style=" margin-bottom: 10px">Thêm sản phẩm</button>
                            <table class="table table-striped">
                                <tbody class="themhanghoa">
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng yêu cầu</th>
                                        <th>Đơn vị</th>
                                        <th>Đơn giá nhập</th>
                                        <th>Thành tiền</th>
                                        <th>Hành động</th>

                                    </tr>
                                    <?php
                                    // Khởi tạo biến $tongTien
                                    $tongTien = 0;




                                    $sql = "SELECT sp.MaSanPham, sp.Ten AS TenSanPham, SoLuong, sp.DonVi, DonGiaNhap, ThanhTien, ctpn.TongTien 
                                    FROM tbl_chitietphieunhap AS ctpn
                                    JOIN tbl_sanpham AS sp ON ctpn.MaSanPham = sp.MaSanPham 
                                    JOIN tbl_phieunhap AS pn ON ctpn.MaPhieuNhap = pn.MaPhieuNhap
                                    WHERE pn.MaPhieuNhap = '$MaPhieuNhapKho'";
                                    $result = $conn->query($sql);
                                    $productIndex = 0;

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>";
                                            echo "<select name='products[$productIndex][MaSP]' class='form-select ProductSelect' onchange='updateProductInfo(this)' required>";
                                            echo "<option selected value='" . $row['MaSanPham'] . "'>" . $row['TenSanPham'] . "</option>";

                                            // Lấy lại danh sách sản phẩm để điền vào select
                                            $productQuery = "SELECT * FROM tbl_sanpham";
                                            $productResult = mysqli_query($conn, $productQuery);
                                            while ($product = mysqli_fetch_assoc($productResult)) {
                                                echo "<option value='" . $product['MaSanPham'] . "' data-donvi='" . $product['DonVi'] . "'>" . $product['Ten'] . "</option>";
                                            }

                                            echo "</select>";
                                            echo "</td>";

                                            echo "<td><input type='number' name='products[$productIndex][SoLuong]' class='form-control' value='" . $row['SoLuong'] . "' required></td>";
                                            echo "<td><input type='text' name='products[$productIndex][DonVi]' class='form-control' value='" . $row['DonVi'] . "' readonly></td>";
                                            echo "<td><input type='number' name='products[$productIndex][DonGia]' class='form-control' value='" . $row['DonGiaNhap'] . "' required></td>";
                                            echo "<td><input type='number' name='products[$productIndex][ThanhTien]' class='form-control' value='" . $row['ThanhTien'] . "' readonly></td>";
                                            echo "<td><button type='button' class='btn btn-danger' onclick='removeProductRow(this)'>Xóa</button></td>";
                                            echo "</tr>";

                                            $productIndex++; // Tăng chỉ mục cho mỗi sản phẩm
                                            $tongTien = $row['TongTien'];

                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Tổng tiền:</strong></td>
                                        <td>

                                            <input type="number" name="TongTien" class="form-control" id="TongTien"
                                                value="<?php echo $tongTien; ?>" readonly>

                                        </td>
                                    </tr>
                                </tfoot>
                            </table>


                            <div class="buttons">
                                <div class="d-grid gap-2 d-md-block">
                                    <button type="submit" name="btn_sua_phieu_yc" class="btn btn-success btn-lg">Xác
                                        nhận</button>
                                    <a href="nvPhieuYeuCau.php"> <button type="button"
                                            class="btn btn-secondary btn-lg ">Quay lại</button></a>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
<script>
    let productIndex = <?php echo $productIndex; ?>;  // Lấy giá trị chỉ mục từ PHP

    // Thêm sản phẩm vào bảng
    function addProductRow() {
        const tbody = document.querySelector('.themhanghoa');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td>
            <select name="products[${productIndex}][MaSP]" class="form-select ProductSelect" required onchange="updateProductInfo(this)">
                <option selected disabled>Chọn sản phẩm</option>
                <?php
                include("../php/connect.php");

                $query = "SELECT * FROM `tbl_sanpham` ";
                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['MaSanPham'] . '" data-donvi="' . $row['DonVi'] . '">' . $row['Ten'] . '</option>';
                    }
                }
                ?>
            </select>
        </td>
        <td><input type="number" name="products[${productIndex}][SoLuong]" class="form-control" required></td>
        <td><input type="text" name="products[${productIndex}][DonVi]" class="form-control" readonly></td>
        <td><input type="number" name="products[${productIndex}][DonGia]" class="form-control" required></td>
        <td><input type="number" name="products[${productIndex}][ThanhTien]" class="form-control" readonly></td>
        <td><button type="button" class="btn btn-danger" onclick="removeProductRow(this)">Xóa</button></td>
    `;
        tbody.appendChild(newRow);
        productIndex++; // Tăng chỉ mục cho sản phẩm mới
    }

    // Cập nhật thông tin sản phẩm khi chọn sản phẩm từ dropdown
    function updateProductInfo(selectElement) {
        const row = selectElement.closest('tr');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const donVi = selectedOption.getAttribute('data-donvi');

        // Cập nhật trường 'DonVi' trong bảng
        row.querySelector('input[name*="[DonVi]"]').value = donVi;

        // Tính toán lại 'ThanhTien'
        updateRowAmount(row);
        updateTotalAmount();
    }

    // Xóa dòng sản phẩm
    function removeProductRow(button) {
        const row = button.closest('tr');
        row.remove();
        updateTotalAmount();
    }

    // Tính toán 'ThanhTien' và cập nhật tổng tiền trong thời gian thực
    document.addEventListener('input', function (event) {
        if (event.target.matches('[name^="products"][name*="[SoLuong]"], [name^="products"][name*="[DonGia]"]')) {
            const row = event.target.closest('tr');
            updateRowAmount(row);
            updateTotalAmount();
        }
    });

    // Cập nhật 'ThanhTien' của từng dòng
    function updateRowAmount(row) {
        const soLuong = row.querySelector('[name*="[SoLuong]"]').value;
        const donGia = row.querySelector('[name*="[DonGia]"]').value;
        const thanhTien = row.querySelector('[name*="[ThanhTien]"]');

        // Tính 'ThanhTien'
        const result = (soLuong * donGia);
        thanhTien.value = result % 1 === 0 ? result : result.toFixed(2);
        updateTotalAmount();

    }

    // Cập nhật tổng tiền của tất cả sản phẩm
    function updateTotalAmount() {
        let totalAmount = 0;
        document.querySelectorAll('[name*="[ThanhTien]"]').forEach(function (input) {
            totalAmount += parseFloat(input.value) || 0;
        });
        document.getElementById('TongTien').value = totalAmount.toFixed(0); // Làm tròn và cập nhật

    }

</script>


<!-- Chọn nhà cung cấp -->
<script>
    document.getElementById('supplierSelect').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        // Lấy dữ liệu bằng getAttribute
        const supplierData = {
            maNCC: selectedOption.getAttribute('data-mancc'),
            tenNCC: selectedOption.getAttribute('data-tenncc'),
            diaChi: selectedOption.getAttribute('data-diachi'),
            soDienThoai: selectedOption.getAttribute('data-sodienthoai'),
            email: selectedOption.getAttribute('data-email'),
            nganhhangcungcap: selectedOption.getAttribute('data-nganhhangcungcap'),
            sanPhamCungCap: selectedOption.getAttribute('data-sanphamcungcap')
        };


        // Hiển thị thông tin trong ThongTinNCC
        const thongTinNCC = document.querySelector('.ThongTinNCC');
        thongTinNCC.style.display = 'block';

        // Cập nhật các trường input
        thongTinNCC.querySelector('input[name="MaNCC"]').value = supplierData.maNCC;
        thongTinNCC.querySelector('input[name="TenNCC"]').value = supplierData.tenNCC;
        thongTinNCC.querySelector('input[name="DiaChi"]').value = supplierData.diaChi;
        thongTinNCC.querySelector('input[name="SoDienThoai"]').value = supplierData.soDienThoai;
        thongTinNCC.querySelector('input[name="Email"]').value = supplierData.email;
        thongTinNCC.querySelector('input[name="NganhHangCungCap"]').value = supplierData.nganhhangcungcap;
        thongTinNCC.querySelector('input[name="SanPhamCungCap"]').value = supplierData.sanPhamCungCap;
    });

</script>



<?php
ob_start();

include("../php/connect.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['btn_sua_phieu_yc'])) {


    // Start transaction
    $conn->begin_transaction();

    try {
        // Retrieve form data
        $MaPhieuNhap = $_POST['MaPhieu'];
        $MaLoaiPhieu = '2'; // Fixed value for Phiếu Nhập Kho
        $MaTrangThaiPhieu = '1'; // Example status value
        $MaNhaCungCap = $_POST['MaNCC'];
        $NgayLapPhieu = $_POST['NgayLapPhieu'];
        $NgayDatHang = $_POST['NgayDatHang'];
        $NgayNhanHang = $_POST['NgayNhanHang'];
        $GhiChu = $_POST['NoiDung'];
        $IDNhanVien = $_POST['NguoiLap'];

        // Calculate TongSoLoaiSanPham (unique product count)
        $products = $_POST['products'];
        $TongSoLoaiSanPham = count(array_unique(array_column($products, 'MaSP')));

        // Update `tbl_phieunhap`
        $stmtPhieuNhap = $conn->prepare("UPDATE tbl_phieunhap SET MaLoaiPhieu=?, MaTrangThaiPhieu=?, MaNhaCungCap=?, NgayLapPhieu=?, NgayDatHang=?, NgayNhanHang=?, TongSoLoaiSanPham=?, GhiChu=? WHERE MaPhieuNhap=?");
        $stmtPhieuNhap->bind_param("ssssssisi", $MaLoaiPhieu, $MaTrangThaiPhieu, $MaNhaCungCap, $NgayLapPhieu, $NgayDatHang, $NgayNhanHang, $TongSoLoaiSanPham, $GhiChu, $MaPhieuNhap);
        if (!$stmtPhieuNhap->execute()) {
            throw new Exception("Không thể cập nhật vào tbl_phieunhap: " . $stmtPhieuNhap->error);
        }
        // Update `tbl_chitietphieunhap` for each product
        $productIds = array_column($products, 'MaSP');

        // Step 1: Delete products that are no longer in the updated list
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $deleteStmt = $conn->prepare("DELETE FROM tbl_chitietphieunhap WHERE MaPhieuNhap = ? AND MaSanPham NOT IN ($placeholders)");
        $deleteStmt->bind_param(str_repeat('s', count($productIds) + 1), $MaPhieuNhap, ...$productIds);

        if (!$deleteStmt->execute()) {
            throw new Exception("Không thể xóa chi tiết sản phẩm cũ: " . $deleteStmt->error);
        }
        // Update `tbl_chitietphieunhap` for each product
        foreach ($products as $product) {
            $MaSanPham = $product['MaSP'];
            $SoLuong = $product['SoLuong'];
            $DonGiaNhap = $product['DonGia'];
            $ThanhTien = $product['ThanhTien'];
            $TongTien = $_POST['TongTien'];

            // Check if the product detail already exists
            $checkQuery = $conn->prepare("SELECT MaChiTietPhieuNhap FROM tbl_chitietphieunhap WHERE MaPhieuNhap = ? AND MaSanPham = ?");
            $checkQuery->bind_param("ss", $MaPhieuNhap, $MaSanPham);
            $checkQuery->execute();
            $result = $checkQuery->get_result();

            if ($result->num_rows > 0) {
                // Update existing product detail
                $stmtChiTietPhieuNhap = $conn->prepare("UPDATE tbl_chitietphieunhap SET SoLuong=?, DonGiaNhap=?, ThanhTien=?, TongTien=? WHERE MaPhieuNhap=? AND MaSanPham=?");
                $stmtChiTietPhieuNhap->bind_param("iiddss", $SoLuong, $DonGiaNhap, $ThanhTien, $TongTien, $MaPhieuNhap, $MaSanPham);
                if (!$stmtChiTietPhieuNhap->execute()) {
                    throw new Exception("Không thể cập nhật vào tbl_chitietphieunhap: " . $stmtChiTietPhieuNhap->error);
                }
            } else {
                // Insert new product detail if it doesn't exist
                $stmtChiTietPhieuNhap = $conn->prepare("INSERT INTO tbl_chitietphieunhap (MaChiTietPhieuNhap, MaPhieuNhap, MaSanPham, SoLuong, DonGiaNhap, ThanhTien, TongTien) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $MaChiTietPhieuNhap = ''; // Auto-increment ID
                $stmtChiTietPhieuNhap->bind_param("sssiidd", $MaChiTietPhieuNhap, $MaPhieuNhap, $MaSanPham, $SoLuong, $DonGiaNhap, $ThanhTien, $TongTien);
                if (!$stmtChiTietPhieuNhap->execute()) {
                    throw new Exception("Không thể chèn vào tbl_chitietphieunhap: " . $stmtChiTietPhieuNhap->error);
                }
            }
        }

        // Update `tbl_nhanvienkho_taophieu_nhap`
        $stmtNhanVien = $conn->prepare("UPDATE tbl_nhanvienkho_taophieu_nhap SET IDNhanVien = ? WHERE MaPhieuNhap = ?");
        $stmtNhanVien->bind_param("is", $IDNhanVien, $MaPhieuNhap);
        if (!$stmtNhanVien->execute()) {
            throw new Exception("Không thể cập nhật vào tbl_nhanvienkho_taophieu_nhap: " . $stmtNhanVien->error);
        }

        // Commit transaction
        $conn->commit();
        $_SESSION['message'] = "Phiếu nhập kho đã được cập nhật thành công!";
        echo "<script>
        window.location.href = 'nvPhieuYeuCau.php';
        </script>";
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi khi cập nhật phiếu nhập kho: " . $e->getMessage();
    } finally {
        // Close statements
        $stmtPhieuNhap->close();
        $stmtNhanVien->close();
        if (isset($stmtChiTietPhieuNhap)) {
            $stmtChiTietPhieuNhap->close();
        }
        $conn->close();
    }
}
ob_end_flush();
?>



<script type="text/javascript" src="../js/phanPhoiDonHang_Ship.js"></script>
</body>

</html>