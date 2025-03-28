<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>

<?php
include("../config/init.php");
include("../php/thongBao.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['ThongTinDangNhap']) || !isset($_SESSION['MaVaiTro'])) {
    $_SESSION['errorMessages'] = "Bạn phải đăng nhập để truy cập trang này!";
    header("Location: login.php");
    exit;
}

// Kiểm tra quyền truy cập: chỉ nhân viên kiểm kêkê (MaVaiTro = 3) mới được truy cập
if ($_SESSION['MaVaiTro'] != '3') {
    $_SESSION['errorMessages'] = "Bạn không có quyền truy cập trang này!";
    header("Location: login.php");
    exit;
}

?>
<?php include("../php/header_heThong.php"); ?>
<?php include("../php/sidebar_heThong.php"); ?>
<?php include("../php/connect.php"); ?>

<?php
include("../config/init.php");
ob_start();
include("../php/thongBao.php");


// Lấy thông tin phiếu nhập từ GET
$maPhieuNhap = $_GET['MaPhieuNhap'] ?? null;
$maBienBan = $_GET['MaBienBan'] ?? null;

if (!$maPhieuNhap) {
    header("Location: ./nvkkXuLyDonHang.php"); // Chuyển hướng nếu không có mã phiếu nhập
    exit;
}


// Truy vấn thông tin phiếu nhập
$sqlPhieuNhap = "SELECT * FROM tbl_phieunhap 
JOIN tbl_nhanvienkho_taophieu_nhap AS nvk
ON nvk.MaPhieuNhap = tbl_phieunhap.MaPhieuNhap
JOIN tbl_user AS u
ON u.IDNhanVien = nvk.IDNhanVien
 WHERE tbl_phieunhap.MaPhieuNhap = ?";
$stmt = $conn->prepare($sqlPhieuNhap);
$stmt->bind_param("s", $maPhieuNhap);
$stmt->execute();
$resultPhieuNhap = $stmt->get_result();
$phieuNhap = $resultPhieuNhap->fetch_assoc();

// Truy vấn chi tiết phiếu nhập
$sqlChiTiet = "SELECT * FROM tbl_chitietphieunhap AS ct
JOIN tbl_sanpham AS sp
ON sp.MaSanPham=ct.MaSanPham
JOIN tbl_chitietbienban AS ctbb
ON ctbb.MaChiTietPhieuNhap=ct.MaChiTietPhieuNhap
WHERE ct.MaPhieuNhap = ? AND ctbb.MaBienBan = ?";
$stmtChiTiet = $conn->prepare($sqlChiTiet);
$stmtChiTiet->bind_param("ss", $maPhieuNhap, $maBienBan);
$stmtChiTiet->execute();
$resultChiTiet = $stmtChiTiet->get_result();

// Truy vấn thông tin biên bản
$sqlBienBan = "SELECT MaBienBan, NgayLapBienBan, LyDo, NguoiLapBienBan, u.Ten AS TenNguoiLapBienBan FROM tbl_bienban 
JOIN tbl_user AS u
ON u.IDNhanVien = tbl_bienban.NguoiLapBienBan
 WHERE tbl_bienban.MaBienBan =  ?";
$stmtBB = $conn->prepare($sqlBienBan);
$stmtBB->bind_param("s", $maBienBan);
$stmtBB->execute();
$resultPhieuBB = $stmtBB->get_result();
$bienban = $resultPhieuBB->fetch_assoc();



?>
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Kiểm kê phiếu nhập">Kiểm kê phiếu nhập
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Chi tiết</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">

                            <div class="col-6">
                                <form action="../php/nvkkXuLyDonHang_Nhap_XuLy.php" method="post">


                                    <dt class="col-sm-3">Mã yêu cầu đổi trả:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="MaYeuCauDoiTra"
                                                placeholder="Mã phiếu yêu cầu đổi trả" class="form-control"
                                                value=" <?php echo $phieuNhap['MaYeuCauDoiTra']; ?>" readonly>
                                        </div>
                                    </dd>

                                    <dt class="col-sm-3">Mã phiếu nhập:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="MaPhieuNhap"
                                                placeholder="Mã phiếu nhập được tạo tự động" class="form-control"
                                                value=" <?php echo $phieuNhap['MaPhieuNhap']; ?>" readonly>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Mã biên bản kiểm kê:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="MaBienBan"
                                                placeholder="Mã biên bản được tạo tự động" class="form-control"
                                                value=" <?php echo $bienban['MaBienBan']; ?>" readonly>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Người lập phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="NguoiLapPhieu" id="NguoiLapPhieu"
                                                value=" <?php echo $phieuNhap['Ten']; ?>" class="form-control" disabled>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Ghi chú:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3" name="GhiChuKiemKe" id="GhiChuKiemKe">
                                            <input type="text" name="GhiChuKiemKe" id="GhiChuKiemKe"
                                                value="<?php echo $bienban['LyDo']; ?>" class="form-control"
                                                disabled>

                                        </div>
                                    </dd>
                            </div>
                            <div class="col-6">
                                <dt class="col-sm-3">Người kiểm kê:</dt>
                                <dd class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="text"   value="<?php echo $bienban['TenNguoiLapBienBan']; ?>"
                                            placeholder="Lấy tên của người kiểm kê" class="form-control" disabled>
                                    </div>
                                </dd>
                                <dt class="col-sm-3">Ngày lập phiếu:</dt>
                                <dd class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="date" name="NgayLapPhieu" id="NgayLapPhieu"
                                            value="<?php echo $phieuNhap['NgayLapPhieu']; ?>" class="form-control"
                                            readonly>
                                    </div>
                                </dd>
                                <dt class="col-sm-3">Ngày lập kiểm kê:</dt>

                                <dd class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="date" name="NgayLapBienBan" id="NgayLapBienBan"
                                            value="<?php echo $bienban['NgayLapBienBan']; ?>" class="form-control"
                                            readonly>
                                    </div>
                                </dd>
                            </div>
                        </dl>
                        <dt class="col-sm-3 mb-4">Danh sách yêu cầu:</dt>

                        <table class="table table-striped table-bordered table-responsive mb-4" id="productList">
                            <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng yêu cầu</th>
                                    <th>Số lượng thực tế</th>
                                    <th>Đơn vị</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($chiTiet = $resultChiTiet->fetch_assoc()) { ?>
                                    <tr>
                                        <td> <input type="text" name="MaSanPham"
                                        value="<?php echo $chiTiet['MaSanPham']; ?>" class="form-control" readonly>
                                        </td>
                                        <td> <input type="text" name="Ten"
                                        value="   <?php echo $chiTiet['Ten']; ?>" class="form-control" readonly>
                                     </td>
                                        <td>
                                            <input type="text" name="SoLuong"
                                                value="<?php echo $chiTiet['SoLuong']; ?>" class="form-control" readonly>

                                        </td>
                                        <td>
                                            <input type="text" name="SoLuongThucTe"
                                                value="<?php echo $chiTiet['SoLuongThucTe']; ?>" class="form-control"
                                                readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="DonVi" value="<?php echo $chiTiet['DonVi']; ?>"
                                                class="form-control" readonly>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <input type="hidden" name="productData" id="productData">

                        </table>

                        <div class="buttons">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="./nvkkXuLyDonHang.php" class="btn btn-secondary btn-lg" tabindex="-1"
                                    role="button" aria-disabled="true">Quay lại</a>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
</body>

</html>