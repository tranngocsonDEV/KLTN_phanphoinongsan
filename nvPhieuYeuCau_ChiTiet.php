<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<?php
include("../config/init.php"); // Khởi tạo session và các cài đặt ban đầu
include("../php/connect.php"); // Kết nối cơ sở dữ liệu

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['ThongTinDangNhap']) || !isset($_SESSION['MaVaiTro'])) {
    $_SESSION['errorMessages'] = "Bạn phải đăng nhập để truy cập trang này!";
    header("Location: login.php");
    exit;
}

// Kiểm tra quyền truy cập: chỉ nhân viên kho (MaVaiTro = 2) mới được truy cập
if ($_SESSION['MaVaiTro'] != '2') {
    $_SESSION['errorMessages'] = "Bạn không có quyền truy cập trang này!";
    header("Location: login.php");
    exit;
}

// Nếu vượt qua kiểm tra quyền truy cập, hiển thị trang thống kê
?>
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
                                $MaPhieu = $_GET['MaPhieuNhapKho'];
                            }
                            // Thực hiện truy vấn và hiển thị thông tin chi tiết
                            $sql = "SELECT pyc.MaPhieu, lp.TenLoai, tbl_user.manhanvien, pyc.TrangThai, pyc.GhiChu,
                                pyc.NgayLap, pyc.SoLuong, kh.TenKH, kh.DiaChi, kh.SoDienThoai 
                                FROM tbl_phieuyeucau AS pyc
                                JOIN tbl_loaiphieu AS lp ON pyc.MaLoai=lp.MaLoai
                                JOIN tbl_user ON  pyc.id=tbl_user.id
                                JOIN tbl_khachhang AS kh ON pyc.MaKH=kh.MaKH
                                WHERE MaPhieu= '$MaPhieu'";
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
                                    echo "<dt class='col-sm-3'>Ngày lập phiếu:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayLapPhieu'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ngày đặt hàng:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayDatHang'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ngày nhận hàng:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayNhanHang'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Mã NCC:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaNCC'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Nhà cung cấp:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TenNCC'] . "</dd>";
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
                                    echo "</div>";
                                }
                            }
                            ?>

                            <dt class="col-sm-3">Danh sách yêu cầu:</dt>
                        </dl>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng yêu cầu</th>
                                    <th>Đơn vị</th>
                                    <th>Đơn giá nhập</th>
                                    <th>Thành tiền</th>
                                </tr>
                                <?php
                                include("../php/connect.php");

                                if (isset($_GET['MaPhieuNhapKho'])) {
                                    $MaPhieu = $_GET['MaPhieuNhapKho'];
                                }
                                // Thực hiện truy vấn và hiển thị thông tin chi tiết
                                $sql = "SELECT sp.TenSanPham, ct.SoLuong, ct.DonVi, ct.DonGia, pyc.TongTien
                                    FROM tbl_chitietphieuyeucau AS ct
                                    JOIN tbl_sanpham AS sp ON ct.MaSanPham=sp.MaSanPham
                                    JOIN tbl_phieuyeucau AS pyc ON ct.MaPhieu=pyc.MaPhieu
                                    WHERE pyc.MaPhieu= '$MaPhieu'";
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
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Tổng tiền:</strong>
                                        <?php
                                        echo "<td><span id='total_amount'>" . $row['TongTien'] . "</span></td>";
                                        ?>

                                </tr>
                            </tfoot>
                        </table>
                        <div class="buttons">
                            <div class="d-grid gap-2 d-md-block">

                                <a href="./nvPhieuYeuCau.php" class="btn btn-secondary btn-lg" tabindex="-1"
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