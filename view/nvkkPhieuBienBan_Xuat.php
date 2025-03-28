<?php include("../php/header_heThong.php"); ?>

<?php include("../php/sidebar_heThong.php"); ?>
<?php include("../php/connect.php"); ?>
<?php
session_start();
ob_start();
include("../php/thongBao.php");
?>

<main class="pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" s="du-lieu-title" data-title="Biên bản">Biên bản</div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="btn_BienBan">
                    <a href="./nvkkLapBienBan.php">
                        <button class="btn  btn-success btn-md"
                            style=" float: left;padding: 5px; margin-bottom: 10px; margin-right:10px;">Tạo biên
                            bản nhập</button>
                    </a>
                    <a href="./nvkkLapBienBan_Xuat.php">
                        <button class="btn  btn-success btn-md"
                            style=" float: left;padding: 5px; margin-bottom: 10px; margin-right:10px;">Tạo biên
                            bản xuất</button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Loaị phiếu -->
        <div class="row">
            <!-- Phân phoại phiếu -->
            <div class="phanLoaiPhieu d-flex">
                <!-- Loại phiếu -->
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Loại phiếu
                            </button>
                            <div class="dropdown-menu p-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="LocPhieu" value="2"
                                        id="LocPhieuNhap" checked>
                                    <label class="form-check-label" for="LocPhieuNhap">Phiếu nhập</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="LocPhieu" value="1"
                                        id="LocPhieuXuat">
                                    <label class="form-check-label" for="LocPhieuXuat">Phiếu xuất</label>
                                </div>
                                <div class="d-grid gap-2" style="width: 100%;">
                                    <button type="button" id="findRequest" class="btn btn-primary action">ÁP
                                        DỤNG</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Phiếu xuất</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered table-responsive data-table"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Mã biên bản</th>
                                        <th>Mã phiếu xuất</th>
                                        <th>Người lập biên bản</th>
                                        <th>Ngày lập</th>
                                        <th>Lý do</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    include("../php/connect.php");
                                    $sql = "
                                      SELECT DISTINCT bb.MaBienBan, px.MaPhieuXuat, bb.NguoiLapBienBan, bb.NgayLapBienBan, LyDo,  u.Ten AS TenNguoiLapBB
                                    FROM tbl_bienban AS bb
                                    INNER JOIN  tbl_chitietbienban AS ct
                                      ON ct.MaBienBan=bb.MaBienBan
                                    INNER JOIN tbl_chitietphieuxuat AS ctpx
                                    ON ctpx.MaChiTietPhieuXuat = ct.MaChiTietPhieuXuat
                                    INNER JOIN tbl_phieuxuat AS px
                                    ON px.MaPhieuXuat = ctpx.MaPhieuXuat
                                    INNER JOIN tbl_user AS u
									ON bb.NguoiLapBienBan = u.IDNhanVien
                                    WHERE TinhTrangChatLuong = 'KhongDat' AND MaChiTietPhieuNhap IS NULL";
                                    $result = $conn->query($sql);

                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['MaBienBan'] . "</td>";
                                        echo "<td>" . $row['MaPhieuXuat'] . "</td>";
                                        echo "<td>" . $row['TenNguoiLapBB'] . "</td>";
                                        echo "<td>" . $row['NgayLapBienBan'] . "</td>";
                                        echo "<td>" . $row['LyDo'] . "</td>";
                                        echo "<td><button class='btn btn-primary btn-md'
                                            onclick=\"window.location='phieuBienBanChiTiet_Xuat.php?MaBienBan=" . $row['MaBienBan'] . "'\">Xem</button></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Lưu giá trị đã chọn vào localStorage
        document.getElementById("findRequest").addEventListener("click", function () {
            // Lấy giá trị của loại phiếu được chọn
            var selectedOption = document.querySelector('input[name="LocPhieu"]:checked').value;

            // Lưu giá trị đã chọn vào localStorage
            localStorage.setItem("selectedOption", selectedOption);

            if (selectedOption === "2") {
                // Điều hướng đến trang phiếu nhập
                window.location.href = "./nvkkPhieuBienBan.php";
            } else if (selectedOption === "1") {
                // Điều hướng đến trang phiếu xuất
                window.location.href = "./nvkkPhieuBienBan_Xuat.php";
            }
        });

        // Khi tải trang, đặt trạng thái checked cho radio button dựa trên giá trị trong localStorage
        document.addEventListener("DOMContentLoaded", function () {
            // Lấy giá trị đã lưu trong localStorage
            var selectedOption = localStorage.getItem("selectedOption");

            // Nếu có giá trị đã lưu, đặt trạng thái checked cho radio button
            if (selectedOption) {
                var radioButton = document.querySelector('input[name="LocPhieu"][value="' + selectedOption + '"]');
                if (radioButton) {
                    radioButton.checked = true;
                }
            }
        });
    </script>
    </div>
</main>
</body>

</html>