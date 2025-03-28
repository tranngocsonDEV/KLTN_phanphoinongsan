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
                            // Database connection
                            include("../php/connect.php");



                            if (isset($_GET['MaThanhLy'])) {
                                $MaThanhLy = $_GET['MaThanhLy'];
                            }
                            // Thực hiện truy vấn và hiển thị thông tin chi tiết
                            $sql =
                                "SELECT tl.MaThanhLy, u.Ten AS TenNguoiTao, tt.Ten AS TenTrangThai, tl.GhiChu, tl.ThoiGian, tl.LoaiThanhLy
                            FROM tbl_thanhly AS tl
                            JOIN tbl_a_trangthaiphieuyeucau AS tt
                            ON tl.MaTrangThaiPhieu = tt.MaTrangThaiPhieu
                            JOIN tbl_user AS u
                            ON tl.MaNguoiTao = u.IDNhanVien
                            WHERE tl.MaThanhLy= '$MaThanhLy'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='col-6'>";
                                    echo "<dt class='col-sm-3'>Mã yêu cầu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaThanhLy'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Người tạo:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TenNguoiTao'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Trạng thái:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TenTrangThai'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ghi chú:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['GhiChu'] . "</dd>";
                                    echo "</div>";
                                    echo "<div class='col-6'>";
                                    echo "<dt class='col-sm-3'>Thời điểm tạo yêu cầu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['ThoiGian'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Loại thanh lý:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['LoaiThanhLy'] . "</dd>";
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
                                    <th>Số lượng thanh lý</th>
                                    <th>Đơn vị</th>
                                </tr>
                                <form action="yeuCau_ThanhLy_Duyet_XuLy.php" method="get">
                                    <?php
                                    // Query to get the product liquidation details
                                    $sql = "SELECT sp.MaSanPham, sp.Ten AS TenSanPham, tl.SoLuong AS SoLuongThanhLy, sp.DonVi, tl.MaThanhLy
                                FROM tbl_thanhly AS tl
                                JOIN tbl_sanpham AS sp ON tl.MaSanPham = sp.MaSanPham 
                                WHERE tl.MaThanhLy = '$MaThanhLy'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row['MaSanPham'] . "</td>";
                                            echo "<td>" . $row['TenSanPham'] . "</td>";
                                            echo "<td>" . $row['SoLuongThanhLy'] . "</td>";
                                            echo "<td>" . $row['DonVi'] . "</td>";

                                            // Include hidden inputs for each row to pass data in the form
                                            echo "<input type='hidden' name='MaSanPham' value='" . $row['MaSanPham'] . "' />";
                                            echo "<input type='hidden' name='SoLuongThanhLy' value='" . $row['SoLuongThanhLy'] . "' />";

                                            echo "</tr>";
                                        }
                                    }
                                    ?>

                            </tbody>
                            <tfoot></tfoot>
                        </table>
                        <!-- Hidden field for the liquidation ID -->
                        <input type="hidden" name="MaThanhLy" value="<?= $MaThanhLy ?>" />

                        <!-- Nút Duyệt phiếu -->
                        <button type="submit" name="btn_modify_confirm" class="btn btn-success btn-lg">Duyệt
                            phiếu</button>
                        <button type="submit" name="btn_modify_deny" class="btn btn-danger btn-lg">Hủy
                            phiếu</button>

                        <a href="./yeuCau_ThanhLy.php" class="btn btn-secondary btn-lg" tabindex="-1" role="button"
                            aria-disabled="true">Quay lại</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>

</html>