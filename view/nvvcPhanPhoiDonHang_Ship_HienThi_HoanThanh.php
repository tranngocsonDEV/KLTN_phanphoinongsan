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
                    <div id="status-info"></div>

                    <div class="card-body">
                        <div class="row">
                            <?php
                            include("../php/connect.php");



                            if (isset($_GET['MaPhieuXuat'])) {
                                $MaPhieuXuat = $_GET['MaPhieuXuat'];
                            }
                            // Thực hiện truy vấn và hiển thị thông tin chi tiết
                            $sql = "SELECT DISTINCT tbl_phieuxuat.MaPhieuXuat AS MaPhieuXuatKho, lp.Ten AS Ten, nvk.IDNhanVien AS IDNhanVienKho,
                        u1.Ten AS NhanVienKho,NgayLapPhieu, NgayXuatHang, NgayGiaoHang, TongSoLoaiSanPham,
                        tbl_a_trangthaiphieuyeucau.Ten AS TenTrangThai ,GhiChu, kh.MaKhachHang AS MaKhachHang,
                        kh.Ten AS TenKhachHang, kh.DiaChi, kh.SoDienThoai, kh.Email, kh.NganhNgheKinhDoanh, ctpx.MaShipper, u2.Ten AS TenNhanVienGiaoHang, tt.TrangThaiThanhToan
                                    
                      FROM tbl_phieuxuat  
                      JOIN tbl_a_trangthaiphieuyeucau
                      ON tbl_phieuxuat.MaTrangThaiPhieu = tbl_a_trangthaiphieuyeucau.MaTrangThaiPhieu
                      JOIN tbl_a_loaiphieu AS lp 
                      ON tbl_phieuxuat.MaLoaiPhieu = lp.MaLoaiPhieu
                      JOIN tbl_nhanvienkho_taophieu_xuat AS nvk 
                      ON tbl_phieuxuat.MaPhieuXuat = nvk.MaPhieuXuat
                      JOIN tbl_khachhang AS kh
                      ON tbl_phieuxuat.MaKhachHang = kh.MaKhachHang 
                      JOIN tbl_user AS u1 
                      ON nvk.IDNhanVien = u1.IDNhanVien
                      JOIN tbl_chitietphieuxuat ctpx
                      ON ctpx.MaPhieuXuat=tbl_phieuxuat.MaPhieuXuat
                      JOIN tbl_shipper ship
                      ON ship.MaShipper = ctpx.MaShipper
                      JOIN tbl_user u2
                      ON u2.IDNhanVien = ship.MaShipper
                      JOIN tbl_thanhtoan AS tt
                      ON tt.MaPhieuXuat = tbl_phieuxuat.MaPhieuXuat
                      WHERE tbl_phieuxuat.MaPhieuXuat= '$MaPhieuXuat'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='row mb-4'>";  // Thêm margin dưới cho row
                                    // Cột bên trái
                                    echo "<div class='col-md-6'>";
                                    echo "<div class='mb-2'><strong>Mã phiếu:</strong> " . $row['MaPhieuXuatKho'] . "</div>";
                                    echo "<div class='mb-2'><strong>Tên phiếu:</strong> " . $row['Ten'] . "</div>";
                                    echo "<div class='mb-2'><strong>Người lập:</strong> " . $row['NhanVienKho'] . "</div>";
                                    echo "<div class='mb-2'><strong>Trạng thái:</strong> " . $row['TenTrangThai'] . "</div>";
                                    echo "<div class='mb-2'><strong>Ghi chú:</strong> " . $row['GhiChu'] . "</div>";
                                    echo "<div class='mb-2'><strong>Nhân viên giao hàng:</strong> " . $row['TenNhanVienGiaoHang'] . "</div>";
                                    echo "<div class='mb-2'><strong>Trạng thái thanh toán:</strong> " . $row['TrangThaiThanhToan'] . "</div>";
                                    echo "</div>";

                                    // Cột bên phải
                                    echo "<div class='col-md-6'>";
                                    echo "<div class='mb-2'><strong>Ngày lập phiếu:</strong> " . $row['NgayLapPhieu'] . "</div>";
                                    echo "<div class='mb-2'><strong>Ngày xuất hàng:</strong> " . $row['NgayXuatHang'] . "</div>";
                                    echo "<div class='mb-2'><strong>Ngày giao hàng:</strong> " . $row['NgayGiaoHang'] . "</div>";
                                    echo "<div class='mb-2'><strong>Mã KH:</strong> " . $row['MaKhachHang'] . "</div>";
                                    echo "<div class='mb-2'><strong>Tên khách hàng:</strong> " . $row['TenKhachHang'] . "</div>";
                                    echo "<div class='mb-2'><strong>Địa chỉ:</strong> " . $row['DiaChi'] . "</div>";
                                    echo "<div class='mb-2'><strong>Số điện thoại:</strong> " . $row['SoDienThoai'] . "</div>";
                                    echo "<div class='mb-2'><strong>Email:</strong> " . $row['Email'] . "</div>";
                                    echo "<div class='mb-2'><strong>Ngành nghề kinh doanh:</strong> " . $row['NganhNgheKinhDoanh'] . "</div>";
                                    echo "</div>";

                                    echo "</div>";
                                }

                            }
                            ?>

                            <dt class="col-sm-3">Danh sách yêu cầu:</dt>
                        </div>
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
                                    WHERE px.MaPhieuXuat = '$MaPhieuXuat '";
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

                                <a href="./nvvcPhanPhoiDonHang.php" class="btn btn-secondary btn-lg"
                                    tabindex="-1" role="button" aria-disabled="true">Quay lại</a>
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