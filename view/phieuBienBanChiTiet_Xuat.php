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
                        <h3>Chi tiết biên bản</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <?php
                            include("../php/connect.php");

                            if (isset($_GET['MaBienBan'])) {
                                $MaBienBan = $_GET['MaBienBan']; // $id only exists within the scope of this block
                            }

                            // Thực hiện truy vấn và hiển thị thông tin chi tiết
                            $sql = "SELECT DISTINCT
                                    bb.MaBienBan AS MaBienBanCuaPhieu,bb.LyDo AS LyDoLapBienBan,
                                    bb.NgayLapBienBan, bb.TinhTrangChatLuong, px.MaPhieuXuat,
                                    u1.Ten AS NguoiLapBienBan,
                                    u2.Ten AS NguoiLapPhieuXuat,
                                    'KHÔNG ĐẠT' AS TinhTrang
                                    
                                         FROM tbl_bienban AS bb
                                    INNER JOIN  tbl_chitietbienban AS ct
                                    ON ct.MaBienBan=bb.MaBienBan
                                    INNER JOIN tbl_chitietphieuxuat AS ctpx
                                     ON ct.MaChiTietPhieuXuat=ctpx.MaChiTietPhieuXuat
									INNER JOIN tbl_phieuxuat AS px
                                     ON ctpx.MaPhieuXuat=px.MaPhieuXuat
                                       INNER JOIN tbl_nhanvienkho_taophieu_xuat AS nvk
                                        ON px.MaPhieuXuat=nvk.MaPhieuXuat
                                         INNER JOIN tbl_user AS u1
									ON bb.NguoiLapBienBan = u1.IDNhanVien
                                     INNER JOIN tbl_user AS u2
									ON nvk.IDNhanVien = u2.IDNhanVien
                                    WHERE bb.MaBienBan= '$MaBienBan'";
                            $result = $conn->query(query: $sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='col-6'>";
                                    echo "<dt class='col-sm-3'>Mã biên bản:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaBienBanCuaPhieu'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Mã phiếu xuất:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['MaPhieuXuat'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Người lập phiếu xuất:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NguoiLapPhieuXuat'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Lý do:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['LyDoLapBienBan'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Danh sách yêu cầu:</dt>";
                                    echo "</div>";
                                    echo "<div class='col-6'>";
                                    echo "<dt class='col-sm-3'>Người lập biên bản:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NguoiLapBienBan'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Ngày lập biên bản:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['NgayLapBienBan'] . "</dd>";
                                    echo "<dt class='col-sm-3'>Trạng thái:</dt>";
                                    echo "<dd class='col-sm-9'>" . $row['TinhTrang'] . "</dd>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </dl>
                        <table class="table table-striped table-bordered table-responsive">
                            <tbody>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng yêu cầu</th>
                                    <th>Số lượng thực tế</th>
                                    <th>Đơn vị</th>
                                </tr>
                                <?php
                                include("../php/connect.php");


                                // Thực hiện truy vấn và hiển thị thông tin chi tiết
                                $sql = "SELECT  sp.MaSanPham, sp.Ten AS TenSanPham, ctpx.SoLuong AS SoLuongYeuCau, ct.SoLuongThucTe AS SoLuongSauKhiKiemKe,  sp.DonVi
                                    FROM tbl_chitietbienban AS ct
                                     INNER JOIN tbl_bienban AS bb
                                    ON ct.MaBienBan=bb.MaBienBan
                                    INNER JOIN tbl_chitietphieuxuat AS ctpx
                                     ON ct.MaChiTietPhieuXuat=ctpx.MaChiTietPhieuXuat
									INNER JOIN tbl_phieuxuat AS px
                                     ON ctpx.MaPhieuXuat=px.MaPhieuXuat
                                     JOIN tbl_sanpham AS sp
                                     ON ctpx.MaSanPham=sp.MaSanPham
                                    WHERE bb.MaBienBan= '$MaBienBan'";


                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {

                                        echo "<tr>";
                                        echo "<td>" . $row['MaSanPham'] . "</td>";
                                        echo "<td>" . $row['TenSanPham'] . "</td>";
                                        echo "<td>" . $row['SoLuongYeuCau'] . "</td>";
                                        echo "<td>" . $row['SoLuongSauKhiKiemKe'] . "</td>";
                                        echo "<td>" . $row['DonVi'] . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="buttons">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="./nvkkPhieuBienBan_Xuat.php" class="btn btn-secondary btn-lg" tabindex="-1"
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