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


                            if (isset($_GET['MaYeuCauDoiTra'])) {
                                $MaYeuCauDoiTra = $_GET['MaYeuCauDoiTra'];
                            }
                            // Thực hiện truy vấn và hiển thị thông tin chi tiết
                            $sql = "SELECT 
                            yc.MaYeuCauDoiTra, yc.MaPhieuXuat, lp.Ten AS Ten, yc.NgayLapDoiTra,
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
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='row'>";
                                    echo "<div class='col-6'>";
                                    echo "<dl class='row'>";
                                    echo "<dt class='col-sm-3'>Mã yêu cầu đổi trả:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaYeuCauDoiTra'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Mã phiếu xuất:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaPhieuXuat'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Tên phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['Ten'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Người lập:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NhanVienKho'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Trạng thái:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TenTrangThai'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Lý do:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['LyDoDoiTra'] . "</dd>";
                                    echo "</dl>";
                                    echo "</div>";
                                    echo "<div class='col-6'>";
                                    echo "<dl class='row'>";
                                    echo "<dt class='col-sm-3'>Ngày lập phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayLapDoiTra'] . "</dd>";

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
                                    $MaPhieuXuat = $row['MaPhieuXuat']; // Assign value of MaPhieuXuat from the query result
                            
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

                                $sql = "SELECT sp.MaSanPham, sp.Ten AS TenSanPham, ct.SoLuongDoiTra AS SoLuong, sp.DonVi,  ct.DonGia, ThanhTien, ct.TongTien 
                  FROM tbl_chitietyeucaudoitra AS ct
                  JOIN tbl_sanpham AS sp ON ct.MaSanPham = sp.MaSanPham 
                  JOIN tbl_yeucaudoitra AS yc ON ct.MaYeuCauDoiTra = yc.MaYeuCauDoiTra
                  WHERE yc.MaYeuCauDoiTra = '$MaYeuCauDoiTra'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['MaSanPham'] . "</td>";
                                        echo "<td>" . $row['TenSanPham'] . "</td>";
                                        echo "<td>" . $row['SoLuong'] . "</td>";
                                        echo "<td>" . $row['DonVi'] . "</td>";
                                        echo "<td>" . $row['DonGia'] . "</td>";
                                        echo "<td>" . $row['ThanhTien'] . "</td>";
                                        echo "</tr>";

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
                                <form action="phieuYeuCau_Duyet_Doi_Tra.php" method="GET">
                                    <input type="hidden" name="MaYeuCauDoiTra" value="<?= $MaYeuCauDoiTra ?>" />
                                    <input type="hidden" name="MaPhieuXuat" value="<?= $MaPhieuXuat ?>" />

                                    <button type="submit" name="btn_request_confirm"
                                        class="btn btn-success btn-lg">Duyệt phiếu</button>
                                </form>
                                <!-- Nút Hủy phiếu -->
                                <form action="phieuYeuCau_Duyet_Doi_Tra.php" method="get">
                                    <input type="hidden" name="MaYeuCauDoiTra" value="<?= $MaYeuCauDoiTra ?>" />
                                    <button type="submit" name="btn_request_deny" class="btn btn-danger btn-lg">Hủy
                                        phiếu</button>
                                </form>
                                <a href="./yeuCau_DoiTra.php" class="btn btn-secondary btn-lg" tabindex="-1"
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