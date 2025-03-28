<?php include("../php/header_heThong.php");
?>
<?php include("../php/sidebar_heThong.php"); ?>


<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3">Chi tiết</div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Phiếu yêu cầu chi tiết</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <?php
                            include("../php/connect.php");

                            if (isset($_GET['MaPhieuNhapKho'])) {
                                $MaPhieuNhapKho = $_GET['MaPhieuNhapKho'];
                            }
                            // Thực hiện truy vấn và hiển thị thông tin chi tiết
                            $sql = "SELECT tbl_phieunhap.MaPhieuNhap AS MaPhieuNhapKho, lp.Ten AS Ten, nvk.IDNhanVien AS IDNhanVienKho, u.Ten AS NhanVienKho,
                            NgayLapPhieu, NgayDatHang, NgayNhanHang, TongSoLoaiSanPham, tbl_a_trangthaiphieuyeucau.Ten AS TenTrangThai ,GhiChu, ncc.MaNhaCungCap AS MaNhaCungCap, 
                            ncc.Ten AS TenNhaCungCap, ncc.DiaChi, ncc.SoDienThoai, ncc.Email, ncc.NganhHangCungCap, ncc.SanPhamCungCap 
                            FROM tbl_phieunhap 
                            JOIN tbl_a_trangthaiphieuyeucau ON tbl_phieunhap.MaTrangThaiPhieu = tbl_a_trangthaiphieuyeucau.MaTrangThaiPhieu
                            JOIN tbl_a_loaiphieu AS lp ON tbl_phieunhap.MaLoaiPhieu = lp.MaLoaiPhieu
                            JOIN tbl_nhanvienkho_taophieu_nhap AS nvk ON tbl_phieunhap.MaPhieuNhap = nvk.MaPhieuNhap
                            JOIN tbl_nhacungcap AS ncc
                            ON tbl_phieunhap.MaNhaCungCap = ncc.MaNhaCungCap 
                            JOIN tbl_user AS u ON nvk.IDNhanVien = u.IDNhanVien
                            WHERE tbl_phieunhap.MaPhieuNhap= '$MaPhieuNhapKho'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='row'>";
                                    echo "<div class='col-6'>";
                                    echo "<dl class='row'>";
                                    echo "<dt class='col-sm-3'>Mã phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaPhieuNhapKho'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Tên phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['Ten'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Người lập:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NhanVienKho'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Trạng thái:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TenTrangThai'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ghi chú:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['GhiChu'] . "</dd>";
                                    echo "</dl>";

                                    echo "</div>";

                                    echo "<div class='col-6'>";
                                    echo "<dl class='row'>";

                                    echo "<dt class='col-sm-3'>Ngày lập phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayLapPhieu'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ngày đặt hàng:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayDatHang'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ngày nhận hàng:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayNhanHang'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Mã NCC:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaNhaCungCap'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Nhà cung cấp:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TenNhaCungCap'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Địa chỉ:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['DiaChi'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Số điện thoại:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['SoDienThoai'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Email:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['Email'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ngành hàng cung cấp:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NganhHangCungCap'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Sản phẩm cung cấp:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['SanPhamCungCap'] . "</dd>";
                                    echo "</dl>";

                                    echo "</div>";
                                    echo "</div>";

                                }
                            }
                            ?>

                            <dt class="col-sm-3">Danh sách yêu cầu:</dt>
                        </dl>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng yêu cầu</th>
                                    <th>Đơn vị</th>
                                    <th>Đơn giá nhập</th>
                                    <th>Thành tiền</th>
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

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['MaSanPham'] . "</td>";
                                        echo "<td>" . $row['TenSanPham'] . "</td>";
                                        echo "<td>" . $row['SoLuong'] . "</td>";
                                        echo "<td>" . $row['DonVi'] . "</td>";
                                        echo "<td>" . $row['DonGiaNhap'] . "</td>";
                                        echo "<td>" . $row['ThanhTien'] . "</td>";
                                        echo "</tr>";

                                        // Gán giá trị TongTien từ mỗi hàng vào biến $tongTien (chỉ cần gán 1 lần)
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
                                    <td></td>
                                    <td><strong>Tổng tiền:</strong></td>
                                    <td><span id="total_amount"><?php echo $tongTien; ?></span></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="buttons">
                            <div class="d-grid gap-2 d-md-block">

                                <a href="./phieuYeuCau.php" class="btn btn-secondary btn-lg" tabindex="-1" role="button"
                                    aria-disabled="true">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>

</html>