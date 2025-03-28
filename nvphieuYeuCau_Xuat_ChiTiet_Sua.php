<?php include("../php/header_heThong.php");
// include("../php/sidebar_heThong.php");

?>
<?php
if (isset($_GET["MaPhieuXuatKho"])) {
    $MaPhieuXuatKho = $_GET["MaPhieuXuatKho"];
}
?>

<?php


$sql = "SELECT tbl_phieuxuat.MaPhieuXuat AS MaPhieuXuatKho, lp.Ten AS Ten, nvk.IDNhanVien AS IDNhanVienKho, u.Ten AS NhanVienKho,
                      NgayLapPhieu, NgayXuatHang, NgayGiaoHang, TongSoLoaiSanPham, tbl_a_trangthaiphieuyeucau.Ten AS TenTrangThai ,GhiChu,
                      kh.MaKhachHang AS MaKhachHang, 
                      kh.Ten AS TenKhachHang, kh.DiaChi, kh.SoDienThoai, kh.Email, kh.NganhNgheKinhDoanh
                                            , tt.TrangThaiThanhToan
                      FROM tbl_phieuxuat 
                      JOIN tbl_a_trangthaiphieuyeucau ON tbl_phieuxuat.MaTrangThaiPhieu = tbl_a_trangthaiphieuyeucau.MaTrangThaiPhieu
                      JOIN tbl_a_loaiphieu AS lp ON tbl_phieuxuat.MaLoaiPhieu = lp.MaLoaiPhieu
                      JOIN tbl_nhanvienkho_taophieu_xuat AS nvk ON tbl_phieuxuat.MaPhieuXuat = nvk.MaPhieuXuat
                      JOIN tbl_khachhang AS kh
                      ON tbl_phieuxuat.MaKhachHang = kh.MaKhachHang
                      JOIN tbl_user AS u 
                      ON nvk.IDNhanVien = u.IDNhanVien
                       JOIN tbl_thanhtoan AS tt
                      ON tt.MaPhieuXuat = tbl_phieuxuat.MaPhieuXuat
                      WHERE tbl_phieuxuat.MaPhieuXuat= '$MaPhieuXuatKho'";
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
                        <h3>Phiếu yêu cầu xuất kho</h3>
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
                                                value="<?php echo $row['MaPhieuXuatKho']; ?>" class="form-control"
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
                                    <dt class="col-sm-3">Tình trạng thanh toán:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <select class="form-select" id="TinhTrangThanhToan"
                                                name="TinhTrangThanhToan" aria-label="Tình trạng thanh toán">
                                                <option value="" <?= empty($row['TrangThaiThanhToan']) ? 'selected' : '' ?>>Chọn tình trạng thanh toán</option>
                                                <option value="Đã thanh toán" <?= $row['TrangThaiThanhToan'] == 'Đã thanh toán' ? 'selected' : '' ?>>Đã thanh toán</option>
                                                <option value="Chưa thanh toán" <?= $row['TrangThaiThanhToan'] == 'Chưa thanh toán' ? 'selected' : '' ?>>Chưa thanh toán</option>
                                            </select>
                                        </div>
                                    </dd>

                                    <dt class="col-sm-3">Ghi chú:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="NoiDung" value="<?php echo $row['GhiChu']; ?>"
                                                class="form-control">

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
                                    <dt class="col-sm-3">Ngày xuất hàng:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayXuatHang"
                                                value="<?php echo $row['NgayXuatHang']; ?>" class="form-control"
                                                required>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Ngày giao hàng:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayGiaoHang"
                                                value="<?php echo $row['NgayGiaoHang']; ?>" class="form-control"
                                                required>
                                        </div>
                                    </dd>

                                    <dd class="col-sm-12 d-flex">
                                        <div class="col-sm-9 ">
                                            <div class="input-group mb-3">
                                                <select id="supplierSelect" class="form-select col-sm-9 supplierSelect"
                                                    aria-label="supplierSelect" required>
                                                    <option selected disabled>Chọn khách hàng mới</option>
                                                    <?php
                                                    include("../php/connect.php");
                                                    $query = "SELECT * FROM tbl_khachhang";

                                                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                                    if (mysqli_num_rows(result: $result) > 0) {
                                                        while ($row = mysqli_fetch_assoc(result: $result)) {
                                                            ?>
                                                            <option value="<?php echo $row['MaKhachHang'] ?>"
                                                                data-makh="<?php echo $row['MaKhachHang'] ?>"
                                                                data-tenkh="<?php echo $row['Ten'] ?>"
                                                                data-diachi="<?php echo $row['DiaChi'] ?>"
                                                                data-sodienthoai="<?php echo $row['SoDienThoai'] ?>"
                                                                data-email="<?php echo $row['Email'] ?>"
                                                                data-nganhnghekinhdoanh="<?php echo $row['NganhNgheKinhDoanh'] ?>">
                                                                <?php echo "<p><strong>Mã KH:</strong> " . $row['MaKhachHang'] . "; <strong>Khách hàng:</strong> " . $row['Ten'] . "</p>"; ?>

                                                            </option>
                                                        <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                    </dd>
                                    <div class="ThongTinKH" style="display: block;">
                                        <?php
                                        $sql = "SELECT tbl_phieuxuat.MaPhieuXuat AS MaPhieuXuatKho, lp.Ten AS Ten, nvk.IDNhanVien AS NhanVienKho, 
                                        NgayLapPhieu, NgayXuatHang, NgayGiaoHang, TongSoLoaiSanPham, tbl_a_trangthaiphieuyeucau.Ten AS TenTrangThai ,GhiChu,
                                        kh.MaKhachHang AS MaKhachHang, 
                                        kh.Ten AS TenKhachHang, kh.DiaChi, kh.SoDienThoai, kh.Email, kh.NganhNgheKinhDoanh
                                        FROM tbl_phieuxuat 
                                        JOIN tbl_a_trangthaiphieuyeucau 
                                        ON tbl_phieuxuat.MaTrangThaiPhieu = tbl_a_trangthaiphieuyeucau.MaTrangThaiPhieu
                                        JOIN tbl_a_loaiphieu AS lp 
                                        ON tbl_phieuxuat.MaLoaiPhieu = lp.MaLoaiPhieu
                                        JOIN tbl_nhanvienkho_taophieu_xuat AS nvk 
                                        ON tbl_phieuxuat.MaPhieuXuat = nvk.MaPhieuXuat
                                        JOIN tbl_khachhang AS kh
                                        ON tbl_phieuxuat.MaKhachHang = kh.MaKhachHang
                                        WHERE tbl_phieuxuat.MaPhieuXuat= '$MaPhieuXuatKho'";
                                        $result = $conn->query($sql);
                                        $row = mysqli_fetch_array($result);


                                        ?>
                                        <dt class="col-sm-3">Mã KH:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="MaKH" placeholder="Mã của khách hàng"
                                                    value="<?php echo isset($row['MaKhachHang']) ? $row['MaKhachHang'] : ''; ?>"
                                                    class="form-control" readonly>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Khách hàng:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="TenKH"
                                                    value="<?php echo isset($row['TenKhachHang']) ? $row['TenKhachHang'] : ''; ?>"
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
                                                    placeholder="Nhập số diện thoại khách hàng"
                                                    value="<?php echo isset($row['SoDienThoai']) ? $row['SoDienThoai'] : ''; ?>"
                                                    class="form-control" minlength="9" maxlength="11" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Email:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="email" name="Email" placeholder="Nhập email khách hàng"
                                                    value="<?php echo isset($row['Email']) ? $row['Email'] : ''; ?>"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Ngành nghề kinh doanh:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="NganhNgheKinhDoanh"
                                                    placeholder="Nhập ngành nghề kinh doanh"
                                                    value="<?php echo isset($row['NganhNgheKinhDoanh']) ? $row['NganhNgheKinhDoanh'] : ''; ?>"
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
                                        <th>Đơn giá bán</th>
                                        <th>Thành tiền</th>
                                        <th>Hành động</th>

                                    </tr>
                                    <?php
                                    $tongTien = 0;




                                    $sql = "SELECT sp.MaSanPham, sp.Ten AS TenSanPham, SoLuong, sp.DonVi, DonGiaBan, ThanhTien, ctpx.TongTien 
                                    FROM tbl_chitietphieuxuat AS ctpx
                                    JOIN tbl_sanpham AS sp ON ctpx.MaSanPham = sp.MaSanPham 
                                    JOIN tbl_phieuxuat AS pn ON ctpx.MaPhieuXuat = pn.MaPhieuXuat
                                    WHERE pn.MaPhieuXuat = '$MaPhieuXuatKho'";
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
                                            echo "<td><input type='number' name='products[$productIndex][DonGia]' class='form-control' value='" . $row['DonGiaBan'] . "' required></td>";
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
                                    <a href="nvPhieuYeuCau_Xuat.php"> <button type="button"
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
                    while ($row = mysqli_fetch_assoc(result: $result)) {
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


<!-- Chọn khách hàng -->
<script>
    document.getElementById('supplierSelect').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        // Lấy dữ liệu bằng getAttribute
        const supplierData = {
            maKH: selectedOption.getAttribute('data-makh'),
            tenKH: selectedOption.getAttribute('data-tenkh'),
            diaChi: selectedOption.getAttribute('data-diachi'),
            soDienThoai: selectedOption.getAttribute('data-sodienthoai'),
            email: selectedOption.getAttribute('data-email'),
            nganhNgheKinhDoanh: selectedOption.getAttribute('data-nganhnghekinhdoanh')
        };


        // Hiển thị thông tin trong ThongTinKH
        const thongTinKH = document.querySelector('.ThongTinKH');
        thongTinKH.style.display = 'block';

        // Cập nhật các trường input
        thongTinKH.querySelector('input[name="MaKH"]').value = supplierData.maKH;
        thongTinKH.querySelector('input[name="TenKH"]').value = supplierData.tenKH;
        thongTinKH.querySelector('input[name="DiaChi"]').value = supplierData.diaChi;
        thongTinKH.querySelector('input[name="SoDienThoai"]').value = supplierData.soDienThoai;
        thongTinKH.querySelector('input[name="Email"]').value = supplierData.email;
        thongTinKH.querySelector('input[name="NganhNgheKinhDoanh"]').value = supplierData.nganhNgheKinhDoanh;
    });
</script>



<?php
ob_start();

include("../php/connect.php");


if (isset($_POST['btn_sua_phieu_yc'])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Start transaction
    $conn->begin_transaction();

    try {
        // Retrieve form data
        $MaPhieuXuat = $_POST['MaPhieu'];
        $MaLoaiPhieu = '3'; // 
        $MaTrangThaiPhieu = '1'; // Example status value
        $MaKhachHang = $_POST['MaKH'];
        $NgayLapPhieu = $_POST['NgayLapPhieu'];
        $NgayXuatHang = $_POST['NgayXuatHang'];
        $NgayGiaoHang = $_POST['NgayGiaoHang'];
        $GhiChu = $_POST['NoiDung'];
        $IDNhanVien = $_POST['NguoiLap'];
        $SoTienThanhToan = 0;
        $TongTien = $_POST['TongTien'];
        $TinhTrangThanhToan = $_POST['TinhTrangThanhToan'];

        if ($TinhTrangThanhToan === 'Đã thanh toán') {
            $SoTienThanhToan = $TongTien; // Nếu đã thanh toán, số tiền bằng tổng tiền
        } else {
            $SoTienThanhToan = 0; // Nếu chưa thanh toán, số tiền bằng 0
        }

        if (empty($TinhTrangThanhToan) || !in_array($TinhTrangThanhToan, ['Đã thanh toán', 'Chưa thanh toán'])) {
            $_SESSION['errorMessages'] = "Vui lòng chọn tình trạng thanh toán hợp lệ!";
            echo "<script>
            window.location.href = 'nvphieuYeuCau_Xuat_ChiTiet_Sua.php?MaPhieuXuatKho=$MaPhieuXuat';
            </script>";
            exit;
        }


        if (empty($NgayLapPhieu)) {
            $_SESSION['errorMessages'] = "Ngày lập phiếu không được để trống!";
            echo "<script>window.location.href = 'nvphieuYeuCau_Xuat_ChiTiet_Sua.php?MaPhieuXuatKho=$MaPhieuXuat';</script>";
            exit;
        }
        if (empty($NgayXuatHang)) {
            $_SESSION['errorMessages'] = "Ngày xuất hàng không được để trống!";
            echo "<script>window.location.href = 'nvphieuYeuCau_Xuat_ChiTiet_Sua.php?MaPhieuXuatKho=$MaPhieuXuat';</script>";
            exit;
        }
        if (empty($NgayGiaoHang)) {
            $_SESSION['errorMessages'] = "Ngày giao hàng không được để trống!";
            echo "<script>window.location.href = 'nvphieuYeuCau_Xuat_ChiTiet_Sua.php?MaPhieuXuatKho=$MaPhieuXuat';</script>";
            exit;
        }
        if (empty($IDNhanVien)) {
            $_SESSION['errorMessages'] = "Người lập phiếu không được để trống!";
            echo "<script>window.location.href = 'nvphieuYeuCau_Xuat_ChiTiet_Sua.php?MaPhieuXuatKho=$MaPhieuXuat';</script>";
            exit;
        }

        // Calculate TongSoLoaiSanPham (unique product count)
        $products = $_POST['products'];
        $TongSoLoaiSanPham = count(array_unique(array_column($products, 'MaSP')));

        if (empty($products)) {
            $_SESSION['errorMessages'] = "Vui lòng chọn sản phẩm!";
            echo "<script>
            window.location.href = 'nvphieuYeuCau_Xuat_ChiTiet_Sua.php?MaPhieuXuatKho=$MaPhieuXuat';
                    </script>";
            exit;
        }

        // Update thanhtoan
        $stmtThanhToan = $conn->prepare("UPDATE tbl_thanhtoan SET SoTienThanhToan = ?, TrangThaiThanhToan=? WHERE MaPhieuXuat=?");
        $stmtThanhToan->bind_param("sss", $SoTienThanhToan, $TinhTrangThanhToan, $MaPhieuXuat);
        if (!$stmtThanhToan->execute()) {
            throw new Exception("Không thể chèn vào tbl_thanhtoan: " . $stmtThanhToan->error);
        }

        // Update `tbl_phieuxuat`
        $stmtPhieuXuat = $conn->prepare("UPDATE tbl_phieuxuat SET MaLoaiPhieu=?, MaTrangThaiPhieu=?, MaKhachHang=?, NgayLapPhieu=?, NgayXuatHang=?, NgayGiaoHang=?, TongSoLoaiSanPham=?, GhiChu=? WHERE MaPhieuXuat=?");
        $stmtPhieuXuat->bind_param("ssssssisi", $MaLoaiPhieu, $MaTrangThaiPhieu, $MaKhachHang, $NgayLapPhieu, $NgayXuatHang, $NgayGiaoHang, $TongSoLoaiSanPham, $GhiChu, $MaPhieuXuat);
        if (!$stmtPhieuXuat->execute()) {
            throw new Exception("Không thể cập nhật vào tbl_phieuxuat: " . $stmtPhieuXuat->error);
        }
        // Update `tbl_chitietphieuxuat` for each product
        $productIds = array_column($products, 'MaSP');

        // Step 1: Delete products that are no longer in the updated list
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $deleteStmt = $conn->prepare("DELETE FROM tbl_chitietphieuxuat WHERE MaPhieuXuat = ? AND MaSanPham NOT IN ($placeholders)");
        $deleteStmt->bind_param(str_repeat('s', count($productIds) + 1), $MaPhieuXuat, ...$productIds);

        if (!$deleteStmt->execute()) {
            throw new Exception("Không thể xóa chi tiết sản phẩm cũ: " . $deleteStmt->error);
        }
        // Update `tbl_chitietphieuxuat` for each product
        foreach ($products as $product) {
            $MaSanPham = $product['MaSP'];
            $SoLuong = $product['SoLuong'];
            $DonGiaBan = $product['DonGia'];
            $ThanhTien = $product['ThanhTien'];
            $TongTien = $_POST['TongTien'];


            // Truy vấn TongSoLuong từ bảng tbl_sanpham
            $sql = "SELECT SoLuongTon, Ten FROM tbl_sanpham WHERE MaSanPham = ?";
            $stmt = $conn->prepare($sql); // Sử dụng prepared statement để bảo mật
            $stmt->bind_param("s", $MaSanPham); // Gắn tham số (nếu MaSanPham là chuỗi)
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Lấy giá trị SoLuongTon từ kết quả
                $row = $result->fetch_assoc();
                $SoLuongTon = intval($row['SoLuongTon']);

                // Kiểm tra soLuongThanhLy có lớn hơn TongSoLuong hay không
                if ($SoLuong > $SoLuongTon) {
                    $_SESSION['errorMessages'] = "Số lượng xuất của $MaSanPham không được vượt quá tổng số lượng hiện có ($SoLuongTon)!";
                    echo "<script>
                      window.location.href = 'nvphieuYeuCau_Xuat_ChiTiet_Sua.php?MaPhieuXuatKho=$MaPhieuXuat';
                    </script>";
                    exit;
                }
            } else {
                $_SESSION['errorMessages'] = "Không tìm thấy sản phẩm với mã $MaSanPham!";
                echo "<script>
                      window.location.href = 'nvphieuYeuCau_Xuat_ChiTiet_Sua.php?MaPhieuXuatKho=$MaPhieuXuat';
                </script>";
                exit;
            }




            // Check if the product detail already exists
            $checkQuery = $conn->prepare("SELECT MaChiTietPhieuXuat FROM tbl_chitietphieuxuat WHERE MaPhieuXuat = ? AND MaSanPham = ?");
            $checkQuery->bind_param("ss", $MaPhieuXuat, $MaSanPham);
            $checkQuery->execute();
            $result = $checkQuery->get_result();

            if ($result->num_rows > 0) {
                // Update existing product detail
                $stmtChiTietPhieuXuat = $conn->prepare("UPDATE tbl_chitietphieuxuat SET SoLuong=?, DonGiaBan=?, ThanhTien=?, TongTien=? WHERE MaPhieuXuat=? AND MaSanPham=?");
                $stmtChiTietPhieuXuat->bind_param("iiddss", $SoLuong, $DonGiaBan, $ThanhTien, $TongTien, $MaPhieuXuat, $MaSanPham);
                if (!$stmtChiTietPhieuXuat->execute()) {
                    throw new Exception("Không thể cập nhật vào tbl_chitietphieuxuat: " . $stmtChiTietPhieuXuat->error);
                }
            } else {
                $stmtChiTietPhieuXuat = $conn->prepare("INSERT INTO tbl_chitietphieuxuat (MaChiTietPhieuXuat, MaPhieuXuat, MaSanPham, SoLuong, DonGiaBan, ThanhTien, TongTien) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $MaChiTietPhieuXuat = ''; // Auto-increment ID
                $stmtChiTietPhieuXuat->bind_param("sssiidd", $MaChiTietPhieuXuat, $MaPhieuXuat, $MaSanPham, $SoLuong, $DonGiaBan, $ThanhTien, $TongTien);
                if (!$stmtChiTietPhieuXuat->execute()) {
                    throw new Exception("Không thể chèn vào tbl_chitietphieuxuat: " . $stmtChiTietPhieuXuat->error);
                }
            }
        }

        // Update `tbl_nhanvienkho_taophieu_xuat`
        $stmtNhanVien = $conn->prepare("UPDATE tbl_nhanvienkho_taophieu_xuat SET IDNhanVien = ? WHERE MaPhieuXuat = ?");
        $stmtNhanVien->bind_param("is", $IDNhanVien, $MaPhieuXuat);
        if (!$stmtNhanVien->execute()) {
            throw new Exception("Không thể cập nhật vào tbl_nhanvienkho_taophieu_xuat: " . $stmtNhanVien->error);
        }

        // Commit transaction
        $conn->commit();
        $_SESSION['message'] = "Phiếu xuất kho đã được cập nhật thành công!";
        echo "<script>
        window.location.href = 'nvPhieuYeuCau_Xuat.php';
        </script>";
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi khi cập nhật phiếu xuất kho: " . $e->getMessage();
    } finally {
        // Close statements
        $stmtThanhToan->close();
        $stmtPhieuXuat->close();
        $stmtNhanVien->close();
        if (isset($stmtChiTietPhieuXuat)) {
            $stmtChiTietPhieuXuat->close();
        }
        $conn->close();
    }
}
ob_end_flush();
?>



<script type="text/javascript" src="../js/phanPhoiDonHang_Ship.js"></script>
</body>

</html>