<?php
$conn = new mysqli("localhost", "son_cnmoi", "12345678", "duan_cnmoi1");
mysqli_set_charset($conn, "utf8mb4");

if ($conn->connect_error) {
    echo "Lỗi kết nối MYSQLLi" . $conn->connect_error;
    exit();
}
?>
<?php
include("../php/header_heThong.php");
?>


<?php
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
                        <h3>Phiếu yêu cầu nhập kho</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <?php

                            include("../php/thongBao.php");
                            if (isset($_GET['MaPhieu'])) {
                                $MaPhieu = $_GET['MaPhieu'];
                            }
                            // Thực hiện truy vấn và hiển thị thông tin chi tiết
                            $sql = "SELECT pyc.MaPhieu, lp.TenLoai, tbl_user.manhanvien, pyc.TrangThai, pyc.GhiChu,
                                pyc.NgayLap, pyc.SoLuong, kh.TenKH, kh.DiaChi, kh.SoDienThoai 
                                FROM tbl_phieuyeucau AS pyc
                                JOIN tbl_loaiphieu AS lp ON pyc.MaLoai=lp.MaLoai
                                JOIN tbl_user ON  pyc.id=tbl_user.id
                                JOIN tbl_khachhang AS kh ON pyc.MaKH=kh.MaKH
                                WHERE MaPhieu= " . $MaPhieu;

                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='col-6'>";
                                    echo "<dt class='col-sm-3'>Mã phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaPhieu'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Tên phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TenLoai'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Người lập:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['manhanvien'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Trạng thái:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TrangThai'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ghi chú:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['GhiChu'] . "</dd>";
                                    echo "</div>";
                                    echo "<div class='col-6'>";
                                    echo "<dt class='col-sm-3'>Ngày đặt hàng:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayLap'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Tên khách hàng:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TenKH'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Địa chỉ:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['DiaChi'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Số điện thoại:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['SoDienThoai'] . "</dd>";
                                    echo "</div>";
                                }
                            }
                            ?>

                            <dt class="col-sm-3">Danh sách yêu cầu:</dt>
                        </dl>
                        <table class="table table-striped table-bordered table-responsive">
                            <tbody>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng yêu cầu</th>
                                    <th>Đơn vị</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                                <?php
                                include("../php/connect.php");

                                if (isset($_GET['MaPhieu'])) {
                                    $MaPhieu = $_GET['MaPhieu'];
                                }
                                // Thực hiện truy vấn và hiển thị thông tin chi tiết
                                $sql = "SELECT sp.TenSanPham, ct.SoLuong, ct.DonVi, ct.DonGia, pyc.TongTien
                                    FROM tbl_chitietphieuyeucau AS ct
                                    JOIN tbl_sanpham AS sp ON ct.MaSanPham=sp.MaSanPham
                                    JOIN tbl_phieuyeucau AS pyc ON ct.MaPhieu=pyc.MaPhieu
                                    WHERE pyc.MaPhieu= " . $MaPhieu;
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {

                                        echo "<tr>";
                                        echo "<td>" . $row['TenSanPham'] . "</td>";
                                        echo "<td>" . $row['SoLuong'] . "</td>";
                                        echo "<td>" . $row['DonVi'] . "</td>";
                                        echo "<td>" . $row['DonGia'] . "</td>";
                                        $thanhTien = $row['SoLuong'] * $row['DonGia'];
                                        echo "<td>" . $thanhTien . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Tổng tiền:</th>
                                    <th>
                                        <?php
                                        include("../php/connect.php");


                                        if (isset($_GET['MaPhieu'])) {
                                            $MaPhieu = $_GET['MaPhieu'];
                                        }
                                        // Thực hiện truy vấn và hiển thị thông tin chi tiết
                                        $sql = "SELECT sp.TenSanPham, ct.SoLuong, ct.DonVi, ct.DonGia, pyc.TongTien FROM tbl_chitietphieuyeucau AS ct
                                            JOIN tbl_sanpham AS sp ON ct.MaSanPham=sp.MaSanPham
                                            JOIN tbl_phieuyeucau AS pyc ON ct.MaPhieu=pyc.MaPhieu
                                            WHERE pyc.MaPhieu= " . $MaPhieu;
                                        $result = $conn->query($sql);
                                        $TongTien = 0;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                if (isset($row['TongTien'])) {
                                                    $TongTien = $row['TongTien'];
                                                    break;
                                                }
                                            }
                                        }
                                        echo $TongTien;
                                        ?>
                                    </th>

                                </tr>
                            </tfoot>
                        </table>
                        <div class="buttons">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="phieuYeuCau_Duyet.php?MaPhieu=<?php echo $MaPhieu; ?>"
                                    class="btn btn-primary btn-lg" tabindex="-1" role="button"
                                    aria-disabled="true">Duyệt phiếu</a>

                                <a href="phieuYeuCau_Huy.php?MaPhieu=<?php echo $MaPhieu; ?>"
                                    class="btn btn-danger btn-lg" tabindex="-1" role="button" aria-disabled="true">Hủy
                                    phiếu</a>
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