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

// Kiểm tra quyền truy cập: chỉ quản lý hệ thống (MaVaiTro = 1) mới được truy cập
if ($_SESSION['MaVaiTro'] != '1') {
    $_SESSION['errorMessages'] = "Bạn không có quyền truy cập trang này!";
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../img/logo32.png" type="image/x-icon">

    <title>Quản lý thống kê</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
</head>

<body>
    <script type="text/javascript" src="../js/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
    <!-- navbar -->

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <!-- offcanvas trigger -->

            <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                <span class="navbar-toggler-icon" data-bs-target="#offcanvasScrolling"></span>
            </button>

            <!-- offcanvas trigger-->
            <a class="navbar-brand fw-bold me-auto" href=""><img src="../img/logo32.png" height="28" width="28"
                    alt="logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION["ThongTinDangNhap"])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $_SESSION['ThongTinDangNhap']['Ten']; ?>
                                <i class="bi bi-person-circle"></i>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="../view/thongTin_Xem.php">Thông tin</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../view/thongTin_ChinhSua.php">Cài đặt</a>
                                </li>
                                <li>
                                    <form action="dangXuat.php" method="post">
                                        <button type="submit" name="logout_btn" class="dropdown-item">Đăng xuất</button>
                                        <!-- <a class="dropdown-item" href="../view/dangXuat.php">Đăng xuất</a> -->
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="../view/dangXuat.php">Đăng xuất</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </nav>


    <?php
    include("../php/sidebar_heThong.php")
        ?>

    <main class="mt-5 pt-3">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Quản lý thống kê">Quản lý thống kê
                </div>
            </div>

            <form action="" method="get">
                <div class="row mb-3 d-flex">
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label control-label>Loại phiếu</label>
                            <select name="MaLoai" class="form-select" aria-label="MaLoai" required>
                                <option selected disabled>Lựa chọn</option>
                                <option value="2">Phiếu nhập kho</option>
                                <option value="3">Phiếu xuất kho</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label control-label>Ngày bắt đầu</label>
                            <input required type="date" id="NgayBatDau" name="NgayBatDau" class="form-control"
                                value="<?php isset($_GET['NgayBatDau']) == True ? $_GET['NgayBatDau'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label control-label>Ngày kết thúc</label>
                            <input required type="date" id="NgayKetThuc" name="NgayKetThuc" class="form-control"
                                value="<?php isset($_GET['NgayKetThuc']) == True ? $_GET['NgayKetThuc'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
                        <button type="submit" id="submit" class="btn btn-success">Thống kê</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <?php
                // Lấy tham số từ giao diện hoặc đặt giá trị mặc định
                $MaLoai = isset($_GET['MaLoai']) ? htmlspecialchars($_GET['MaLoai'], ENT_QUOTES, 'UTF-8') : '3'; // Mặc định: phiếu xuất
                $NgayBatDau = isset($_GET['NgayBatDau']) ? htmlspecialchars($_GET['NgayBatDau'], ENT_QUOTES, 'UTF-8') : '2000-01-01';
                $NgayKetThuc = isset($_GET['NgayKetThuc']) ? htmlspecialchars($_GET['NgayKetThuc'], ENT_QUOTES, 'UTF-8') : date('Y-m-d');

                // Xác định bảng cần sử dụng dựa trên loại phiếu
                if ($MaLoai == '2') { // Phiếu nhập
                    $tablePhieu = 'tbl_phieunhap';
                    $tableChiTiet = 'tbl_chitietphieunhap';
                    $fieldTongTien = 'ThanhTien';
                    $tableMa = 'MaPhieuNhap';
                    $fieldMaSanPham = 'MaSanPham';
                    $statusCondition = "p.MaTrangThaiPhieu IN (4,6,7) AND   p.MaYeuCauDoiTra IS NULL ";

                } elseif ($MaLoai == '3') { // Phiếu xuất
                    $tablePhieu = 'tbl_phieuxuat';
                    $tableChiTiet = 'tbl_chitietphieuxuat';
                    $fieldTongTien = 'ThanhTien';
                    $tableMa = 'MaPhieuXuat';
                    $fieldMaSanPham = 'MaSanPham';
                    $statusCondition = "p.MaTrangThaiPhieu = 13"; // Trạng thái phiếu xuất
                
                } else {
                    echo '<h4 class="mb-0 text-danger">Loại phiếu không hợp lệ!</h4>';
                    exit;
                }
                // Truy vấn tổng số loại sản phẩm
                $queryTongLoaiSanPham = "
                SELECT COUNT(DISTINCT ct.$fieldMaSanPham) AS TongLoaiSanPham
                FROM `$tableChiTiet` AS ct
                JOIN `$tablePhieu` AS p
                ON ct.$tableMa = p.$tableMa
                WHERE $statusCondition
                AND p.NgayLapPhieu BETWEEN '$NgayBatDau' AND '$NgayKetThuc'
            ";
                $resultLoaiSanPham = mysqli_query($conn, $queryTongLoaiSanPham);

                // Truy vấn số đơn hàng hoàn thành
                $queryDonHangHoanThanh = "
                    SELECT COUNT(*) AS SoDonHang
                    FROM `$tablePhieu` p
                    WHERE $statusCondition
                    AND NgayLapPhieu BETWEEN '$NgayBatDau' AND '$NgayKetThuc'
                ";
                $resultDonHang = mysqli_query($conn, $queryDonHangHoanThanh);

                // Truy vấn tổng doanh thu
                $queryTongDoanhThu = "
        SELECT SUM(ct.$fieldTongTien) AS TongDoanhThu
        FROM `$tableChiTiet` AS ct
        JOIN `$tablePhieu` AS p
        ON ct. $tableMa = p. $tableMa
        WHERE $statusCondition
        AND p.NgayLapPhieu BETWEEN '$NgayBatDau' AND '$NgayKetThuc'
    ";
                $resultDoanhThu = mysqli_query($conn, $queryTongDoanhThu);
                ?>
                <!-- Tổng số loại sản phẩm trong phiếu -->
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-primary h-60">
                        <div class="card-header">Tổng số loại sản phẩm</div>
                        <div class="card-body">
                            <?php
                            if ($dataLoaiSanPham = mysqli_fetch_assoc($resultLoaiSanPham)) {
                                echo '<h4 class="mb-0">' . ($dataLoaiSanPham['TongLoaiSanPham'] ?? 0) . '</h4>';
                            } else {
                                echo '<h4 class="mb-0">Không có dữ liệu</h4>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Tổng số đơn hàng hoàn thành -->
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-primary h-60">
                        <div class="card-header">Tổng số đơn hàng</div>
                        <div class="card-body">
                            <?php
                            if ($dataDonHang = mysqli_fetch_assoc($resultDonHang)) {
                                echo '<h4 class="mb-0">' . ($dataDonHang['SoDonHang'] ?? 0) . '</h4>';
                            } else {
                                echo '<h4 class="mb-0">Không có dữ liệu</h4>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Tổng số doanh thu -->
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-danger h-60">
                        <div class="card-header">Tổng số doanh thu/chi phí</div>
                        <div class="card-body">
                            <?php
                            if ($dataDoanhThu = mysqli_fetch_assoc($resultDoanhThu)) {
                                $tongDoanhThu = $dataDoanhThu['TongDoanhThu'] ?? 0;
                                echo '<h4 class="mb-0">' . number_format($tongDoanhThu, 0, ',', '.') . ' VND</h4>';
                            } else {
                                echo '<h4 class="mb-0">Không có dữ liệu</h4>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Biểu đồ cột</div>
                        <div class="card-body">
                            <canvas id="myChart" width="400" height="200"></canvas>
                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Biều đồ đường</div>
                        <div class="card-body">
                            <canvas id="myChart1" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mt-3">
                <!-- Table -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Bảng dữ liệu</div>
                        <div class="card-body">
                            <div class="table table-striped table-bordered table-responsive">
                                <?php
                                if (isset($_GET['MaLoai']) && $_GET['MaLoai'] != '') {
                                    $MaLoai = htmlspecialchars($_GET['MaLoai'], ENT_QUOTES, 'UTF-8');
                                    $NgayBatDau = htmlspecialchars($_GET['NgayBatDau'], ENT_QUOTES, 'UTF-8');
                                    $NgayKetThuc = htmlspecialchars($_GET['NgayKetThuc'], ENT_QUOTES, 'UTF-8');

                                    if ($MaLoai == '2') {
                                        // Truy vấn cho bảng tbl_phieunhap
                                        $query = "SELECT DISTINCT pn.MaPhieuNhap, l.Ten, pn.NgayLapPhieu, pn.NgayNhanHang, 
                                                     pn.TongSoLoaiSanPham, ctpn.TongTien
                                                , tt.Ten AS TenTrangThai
                                              FROM tbl_phieunhap pn
                                              JOIN tbl_a_loaiphieu l ON pn.MaLoaiPhieu = l.MaLoaiPhieu
                                              JOIN tbl_chitietphieunhap ctpn ON ctpn.MaPhieuNhap = pn.MaPhieuNhap
                                              JOIN tbl_a_trangthaiphieuyeucau AS tt
                                              ON tt.MaTrangThaiPhieu = pn.MaTrangThaiPhieu 
                                              WHERE pn.NgayLapPhieu BETWEEN '$NgayBatDau' AND '$NgayKetThuc'  AND pn.MaTrangThaiPhieu IN (4,6,7) AND pn.MaYeuCauDoiTra IS NULL AND l.MaLoaiPhieu = 2
                                              ORDER BY pn.MaPhieuNhap ASC";
                                    } elseif ($MaLoai == '3') {
                                        // Truy vấn cho bảng tbl_phieuxuat
                                        $query = "SELECT DISTINCT px.MaPhieuXuat, l.Ten, px.NgayLapPhieu, px.NgayXuatHang, 
                                                     px.TongSoLoaiSanPham, ctpx.TongTien
                                                     ,  tt.Ten AS TenTrangThai
                                              FROM tbl_phieuxuat px
                                              JOIN tbl_a_loaiphieu l ON px.MaLoaiPhieu = l.MaLoaiPhieu
                                              JOIN tbl_chitietphieuxuat ctpx ON ctpx.MaPhieuXuat = px.MaPhieuXuat
                                              JOIN tbl_a_trangthaiphieuyeucau AS tt
                                              ON tt.MaTrangThaiPhieu = px.MaTrangThaiPhieu 
                                              WHERE px.NgayLapPhieu BETWEEN '$NgayBatDau' AND '$NgayKetThuc' AND px.MaTrangThaiPhieu = 13
                                              ORDER BY px.MaPhieuXuat ASC";
                                    } else {
                                        echo '<h5 class="text-danger text-center">Không có dữ liệu!</h5>';
                                        exit;
                                    }

                                    // Thực thi truy vấn
                                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                }

                                if (isset($result) && mysqli_num_rows($result) > 0) {
                                    echo '<table id="example" class="table table-striped table-bordered table-responsive">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th>Mã</th>';
                                    echo '<th>Tên phiếu</th>';
                                    echo '<th>Ngày lập</th>';
                                    echo '<th>Ngày giao/nhập hàng</th>';
                                    echo '<th>Trạng thái phiếu yêu cầu</th>';
                                    echo '<th>Tổn số loại sản phẩm</th>';
                                    echo '<th>Tổng tiền</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        echo '<td>' . ($MaLoai == '2' ? $row['MaPhieuNhap'] : $row['MaPhieuXuat']) . '</td>';
                                        echo '<td>' . $row['Ten'] . '</td>';
                                        echo '<td>' . $row['NgayLapPhieu'] . '</td>';
                                        echo '<td>' . ($MaLoai == '2' ? $row['NgayNhanHang'] : $row['NgayXuatHang']) . '</td>';
                                        echo '<td>' . $row['TenTrangThai'] . '</td>';
                                        echo '<td>' . $row['TongSoLoaiSanPham'] . '</td>';
                                        echo '<td>' . $row['TongTien'] . '</td>';
                                        echo '</tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                } else {
                                    echo '<h5 class="text-danger text-center">Không có dữ liệu!</h5>';
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>

    <script>
        new DataTable("#example", {
            language: {
                decimal: "", // Dấu thập phân (có thể để trống nếu không sử dụng)
                emptyTable: "Không có dữ liệu trong bảng", // Thông báo khi bảng không có dữ liệu
                info: "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ bản ghi", // Thông báo khi hiển thị thông tin bảng
                infoEmpty: "Hiển thị 0 đến 0 trong tổng số 0 bản ghi", // Thông báo khi không có bản ghi nào
                infoFiltered: "(đã lọc từ _MAX_ tổng số bản ghi)", // Thông báo khi có dữ liệu lọc
                infoPostFix: "", // Thêm hậu tố vào thông báo info (có thể để trống)
                thousands: ",", // Dấu phân cách hàng nghìn
                lengthMenu: "Hiển thị _MENU_ bản ghi", // Thông báo chọn số lượng bản ghi hiển thị
                loadingRecords: "Đang tải...", // Thông báo khi đang tải dữ liệu
                processing: "", // Thông báo khi đang xử lý (có thể để trống)
                search: "Tìm kiếm:", // Thông báo tìm kiếm
                zeroRecords: "Không tìm thấy kết quả", // Thông báo khi không tìm thấy kết quả

                aria: {
                    orderable: "Sắp xếp theo cột này", // Thông báo sắp xếp cột
                    orderableReverse: "Sắp xếp ngược lại cột này" // Thông báo sắp xếp ngược cột
                }
            }
        });

        function extractTableDateAndSplit() {

            function extractTableDate() {
                const table = document.getElementById('example');
                const dataRows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

                const dataArray = [];
                for (const row of dataRows) {
                    const NgayGiaoHangThanhCong = row.cells[3].textContent;
                    const tongTien = row.cells[6].textContent;
                    dataArray.push({ NgayGiaoHangThanhCong: NgayGiaoHangThanhCong, tongTien: tongTien })
                }
                return dataArray;
            }

            const extractedData = extractTableDate();

            // chia ngay
            const NgayGiaoHangThanhCongArray = extractedData.map(item => item.NgayGiaoHangThanhCong);
            const tongTienArray = extractedData.map(item => item.tongTien);

            return { NgayGHTC: NgayGiaoHangThanhCongArray, TongTien: tongTienArray }
        }

        const barData = extractTableDateAndSplit()
        //    console.log(barData.TongTien)
        // setup 
        const data = {
            labels: barData.NgayGHTC,
            datasets: [{
                label: 'Doanh thu/Chi phí theo ngày',
                data: barData.TongTien,
                backgroundColor: [
                    'rgb(123, 217, 226)',
                    'rgb(113, 208, 228)',
                    'rgb(103, 199, 228)',
                    'rgb(102, 186, 226)',
                    'rgb(97, 179, 222)',
                    'rgb(98, 168, 215)',
                    'rgb(100, 157, 213)'
                ],
                borderColor: [
                    'rgb(123, 217, 226)',
                    'rgb(113, 208, 228)',
                    'rgb(103, 199, 228)',
                    'rgb(102, 186, 226)',
                    'rgb(97, 179, 222)',
                    'rgb(98, 168, 215)',
                    'rgb(100, 157, 213)'
                ],
                borderWidth: 1
            }]
        };

        // config 
        const config = {
            type: 'bar',
            data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // config 
        const config1 = {
            type: 'line',
            data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // render init block
        const myChart = new Chart(
            document.getElementById('myChart'),
            config

        );
        const myChart1 = new Chart(
            document.getElementById('myChart1'),
            config1
        );


        // Instantly assign Chart.js version
        const chartVersion = document.getElementById('chartVersion');
        chartVersion.innerText = Chart.version;
    </script>
</body>

</html>