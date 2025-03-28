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



                            if (isset($_GET['MaPhieuXuatKho'])) {
                                $MaPhieuXuatKho = $_GET['MaPhieuXuatKho'];
                            }
                            // Thực hiện truy vấn và hiển thị thông tin chi tiết
                            $sql = "SELECT tbl_phieuxuat.MaPhieuXuat AS MaPhieuXuatKho, lp.Ten AS Ten, nvk.IDNhanVien AS IDNhanVienKho, u.Ten AS NhanVienKho,
                      NgayLapPhieu, NgayXuatHang, NgayGiaoHang, TongSoLoaiSanPham, tbl_a_trangthaiphieuyeucau.Ten AS TenTrangThai ,GhiChu, kh.MaKhachHang AS MaKhachHang, 
                      kh.Ten AS TenKhachHang, kh.DiaChi, kh.SoDienThoai, kh.Email, kh.NganhNgheKinhDoanh 
                                           , tt.TrangThaiThanhToan

                      FROM tbl_phieuxuat 
                      JOIN tbl_a_trangthaiphieuyeucau ON tbl_phieuxuat.MaTrangThaiPhieu = tbl_a_trangthaiphieuyeucau.MaTrangThaiPhieu
                      JOIN tbl_a_loaiphieu AS lp ON tbl_phieuxuat.MaLoaiPhieu = lp.MaLoaiPhieu
                      JOIN tbl_nhanvienkho_taophieu_xuat AS nvk ON tbl_phieuxuat.MaPhieuXuat = nvk.MaPhieuXuat
                      JOIN tbl_khachhang AS kh
                      ON tbl_phieuxuat.MaKhachHang = kh.MaKhachHang 
                      JOIN tbl_user AS u ON nvk.IDNhanVien = u.IDNhanVien
                        JOIN tbl_thanhtoan AS tt
                      ON tt.MaPhieuXuat = tbl_phieuxuat.MaPhieuXuat
                      WHERE tbl_phieuxuat.MaPhieuXuat= '$MaPhieuXuatKho'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='row'>";
                                    echo "<div class='col-6'>";
                                    echo "<dl class='row'>";
                                    echo "<dt class='col-sm-3'>Mã phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaPhieuXuatKho'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Tên phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['Ten'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Người lập:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NhanVienKho'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Trạng thái:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TenTrangThai'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Tình trạng thanh toán:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TrangThaiThanhToan'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ghi chú:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['GhiChu'] . "</dd>";
                                    echo "</dl>";
                                    echo "</div>";
                                    echo "<div class='col-6'>";
                                    echo "<dl class='row'>";
                                    echo "<dt class='col-sm-3'>Ngày lập phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayLapPhieu'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ngày xuất hàng:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayXuatHang'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ngày giao hàng:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayGiaoHang'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Mã KH:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaKhachHang'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Tên khách hàng:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TenKhachHang'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Địa chỉ:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['DiaChi'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Số điện thoại:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['SoDienThoai'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Email:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['Email'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ngành nghề kinh doanh:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NganhNgheKinhDoanh'] . "</dd>";
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
                                    <th>Đơn giá bán</th>
                                    <th>Thành tiền</th>
                                </tr>
                                <?php
                                // Khởi tạo biến $tongTien
                                $tongTien = 0;

                                $sql = "SELECT sp.MaSanPham, sp.Ten AS TenSanPham, SoLuong, sp.DonVi, DonGiaBan, ThanhTien, ctpx.TongTien 
                  FROM tbl_chitietphieuxuat AS ctpx
                  JOIN tbl_sanpham AS sp ON ctpx.MaSanPham = sp.MaSanPham 
                  JOIN tbl_phieuxuat AS px
                  ON ctpx.MaPhieuXuat = px.MaPhieuXuat
                  WHERE px.MaPhieuXuat = '$MaPhieuXuatKho'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['MaSanPham'] . "</td>";
                                        echo "<td>" . $row['TenSanPham'] . "</td>";
                                        echo "<td>" . $row['SoLuong'] . "</td>";
                                        echo "<td>" . $row['DonVi'] . "</td>";
                                        echo "<td>" . $row['DonGiaBan'] . "</td>";
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
                            <div class="d-flex flex-row gap-1">
                                <!-- Nút Duyệt phiếu -->
                                <form action="phieuYeuCau_Duyet_Phieu_Xuat.php" method="get">
                                    <input type="hidden" name="MaPhieuXuatKho" value="<?= $MaPhieuXuatKho ?>" />
                                    <button type="submit" name="btn_request_confirm"
                                        class="btn btn-success btn-lg">Duyệt phiếu</button>
                                </form>
                                <!-- Nút Hủy phiếu -->
                                <form action="phieuYeuCau_Duyet_Phieu_Xuat.php" method="get">
                                    <input type="hidden" name="MaPhieuXuatKho" value="<?= $MaPhieuXuatKho ?>" />
                                    <button type="submit" name="btn_request_deny" class="btn btn-danger btn-lg">Hủy
                                        phiếu</button>
                                </form>
                                <a href="./phieuYeuCau_Xuat.php" class="btn btn-secondary btn-lg" tabindex="-1"
                                    role="button" aria-disabled="true">Quay lại</a>
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