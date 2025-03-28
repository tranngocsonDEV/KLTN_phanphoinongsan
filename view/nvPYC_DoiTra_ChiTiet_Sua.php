<?php include("../php/header_heThong.php");
include("../php/sidebar_heThong.php");

?>
<?php
if (isset($_GET["MaYeuCauDoiTra"])) {
    $MaYeuCauDoiTra = $_GET["MaYeuCauDoiTra"];
}
?>

<?php


$sql = "SELECT 
                            yc.MaYeuCauDoiTra, yc.MaPhieuXuat,lp.Ten AS Ten, yc.NgayLapDoiTra,
                            yc.NguoiLapDoiTra AS IDNhanVienKho, u.Ten AS NhanVienKho,
                            yc.LyDoDoiTra,
                            yc.MaKhachHang, kh.Ten AS TenKhachHang,
                            kh.DiaChi, kh.SoDienThoai,
                            kh.Email, kh.NganhNgheKinhDoanh,
                            tt.Ten AS TenTrangThai
                            FROM tbl_yeucaudoitra AS yc
                                    JOIN tbl_a_trangthaiphieuyeucau AS tt
                                    ON yc.MaTrangThaiPhieu = tt.MaTrangThaiPhieu
                            JOIN tbl_a_loaiphieu AS lp 
                            ON lp.MaLoaiPhieu = yc.MaLoaiPhieu
                            JOIN tbl_user AS u ON u.IDNhanVien = yc.NguoiLapDoiTra
                            JOIN tbl_khachhang AS kh
                            ON kh.MaKhachHang = yc.MaKhachHang
                            WHERE yc.MaYeuCauDoiTra= '$MaYeuCauDoiTra'";
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
                        <h3>Phiếu yêu cầu đổi trả</h3>
                    </div>
                    <form action="" method="POST">
                        <div class="card-body">
                            <?php
                            include("../php/thongBao.php");
                            ?>


                            <dl class="row">
                                <div class="col-6">
                                    <dt class="col-sm-3">Mã yêu cầu đổi trả:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="MaPhieu" placeholder=""
                                                value="<?php echo $row['MaYeuCauDoiTra']; ?>" class="form-control"
                                                readonly>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Mã phiếu xuất:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="MaPhieuXuat" placeholder=""
                                                value="<?php echo $row['MaPhieuXuat']; ?>" class="form-control"
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
                                    <dt class="col-sm-3">Trạng thái:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" value="<?php echo $row['TenTrangThai']; ?>"
                                                placeholder="Trạng thái của yêu cầu đổi trả" class="form-control"
                                                disabled>

                                            <input type="hidden" name="NguoiLap"
                                                value="<?php echo $row['IDNhanVienKho']; ?>" required>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Ly do:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="LyDo" value="<?php echo $row['LyDoDoiTra']; ?>"
                                                class="form-control" required>

                                        </div>
                                    </dd>
                                </div>
                                <div class="col-6">
                                    <dt class="col-sm-3">Ngày lập phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayLapDoiTra"
                                                value="<?php echo $row['NgayLapDoiTra']; ?>" class="form-control"
                                                required>
                                        </div>
                                    </dd>



                                    <div class="ThongTinKH" style="display: block;">
                                        <?php
                                        $sql = "SELECT 
                     
                            yc.MaKhachHang, kh.Ten AS TenKhachHang,
                            kh.DiaChi, kh.SoDienThoai,
                            kh.Email, kh.NganhNgheKinhDoanh,
                            tt.Ten AS TenTrangThai
                            FROM tbl_yeucaudoitra AS yc
                                    JOIN tbl_a_trangthaiphieuyeucau AS tt
                                    ON yc.MaTrangThaiPhieu = tt.MaTrangThaiPhieu
                            JOIN tbl_a_loaiphieu AS lp 
                            ON lp.MaLoaiPhieu = yc.MaLoaiPhieu
                            JOIN tbl_user AS u ON u.IDNhanVien = yc.NguoiLapDoiTra
                            JOIN tbl_khachhang AS kh
                            ON kh.MaKhachHang = yc.MaKhachHang
                                        WHERE yc.MaYeuCauDoiTra= '$MaYeuCauDoiTra'";
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

                            <table class="table table-striped">
                                <tbody class="themhanghoa">
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng yêu cầu</th>
                                        <th>Đơn vị</th>
                                        <th>Đơn giá bán</th>
                                        <th>Thành tiền</th>

                                    </tr>
                                    <?php
                                    $tongTien = 0;




                                    $sql = "SELECT ct.MaSanPham, sp.Ten AS TenSanPham, ct.SoLuongDoiTra AS SoLuong, sp.DonVi, ct.DonGia AS DonGiaBan, ct.ThanhTien, ct.TongTien 
                                    FROM tbl_chitietyeucaudoitra AS ct
                                    JOIN tbl_sanpham AS sp
                                    ON sp.MaSanPham = ct.MaSanPham
                                    WHERE ct.MaYeuCauDoiTra = '$MaYeuCauDoiTra'";
                                    $result = $conn->query($sql);
                                    $productIndex = 0;

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>";
                                            echo "<select name='products[$productIndex][MaSP]' class='form-select ProductSelect' onchange='updateProductInfo(this)' disabled>";
                                            echo "<option selected value='" . $row['MaSanPham'] . "'>" . $row['TenSanPham'] . "</option>";

                                            // Lấy lại danh sách sản phẩm để điền vào select
                                            $productQuery = "SELECT * FROM tbl_sanpham";
                                            $productResult = mysqli_query($conn, $productQuery);
                                            while ($product = mysqli_fetch_assoc($productResult)) {
                                                echo "<option value='" . $product['MaSanPham'] . "' data-donvi='" . $product['DonVi'] . "'>" . $product['Ten'] . "</option>";
                                            }

                                            echo "</select>";
                                            echo "</td>";
                                            echo "<td><input type='number' name='products[$productIndex][SoLuong]' class='form-control' value='" . $row['SoLuong'] . "' readonly></td>";
                                            echo "<td><input type='text' name='products[$productIndex][DonVi]' class='form-control' value='" . $row['DonVi'] . "' readonly></td>";
                                            echo "<td><input type='number' name='products[$productIndex][DonGia]' class='form-control' value='" . $row['DonGiaBan'] . "' readonly></td>";
                                            echo "<td><input type='number' name='products[$productIndex][ThanhTien]' class='form-control' value='" . $row['ThanhTien'] . "' readonly></td>";
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
                                    <a href="nvYeuCauDoiTra.php"> <button type="button"
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
        $MaPhieuYeuCauDoiTra = $_POST['MaPhieu'];
        $MaLoaiPhieu = '4'; // 
        $MaTrangThaiPhieu = '18';
        $MaKhachHang = $_POST['MaKH'];
        $NgayLapDoiTra = $_POST['NgayLapDoiTra'];

        $LyDoDoiTra = $_POST['LyDo'];
        $IDNhanVien = $_POST['NguoiLap'];

        // Calculate TongSoLoaiSanPham (unique product count)
        $products = $_POST['products'];

        // Update `tbl_yeucaudoitra`
        $stmtPhieuXuat = $conn->prepare("UPDATE tbl_yeucaudoitra SET NgayLapDoiTra = ?, LyDoDoiTra=? WHERE MaYeuCauDoiTra = ?");
        $stmtPhieuXuat->bind_param("ssi", $NgayLapDoiTra, $LyDoDoiTra, $MaPhieuYeuCauDoiTra);
        if (!$stmtPhieuXuat->execute()) {
            throw new Exception("Không thể cập nhật vào tbl_yeucaudoitra: " . $stmtPhieuXuat->error);
        }
        // Commit transaction
        $conn->commit();
        $_SESSION['message'] = "Phiếu yêu cầu đổi trả đã được cập nhật thành công!";
        echo "<script>
        window.location.href = 'nvYeuCauDoiTra.php';
        </script>";
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi khi cập nhật phiếu yêu cầu đổi trả: " . $e->getMessage();
    } finally {
        // Close statements
        $stmtPhieuXuat->close();
        $conn->close();
    }
}
ob_end_flush();
?>



<script type="text/javascript" src="../js/phanPhoiDonHang_Ship.js"></script>
</body>

</html>