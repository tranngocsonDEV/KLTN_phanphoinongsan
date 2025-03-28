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
                        <div class="message_show">
                            <div class="error_message">
                                <h3>Phiếu yêu cầu chi tiết</h3>
                            </div>

                            <div id="status-info"></div>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    include("../php/connect.php");

                                    $maShipperDangNhap = isset($_SESSION['ThongTinDangNhap']['User_id']) ? $_SESSION['ThongTinDangNhap']['User_id'] : null;


                                    if (isset($_GET['MaPhieuXuat'])) {
                                        $MaPhieuXuat = $_GET['MaPhieuXuat'];
                                        $MaYeuCauDoiTra = $_GET['MaYeuCauDoiTra'];

                                        $sqlCheck = "SELECT MaShipper FROM tbl_chitietyeucaudoitra WHERE MaYeuCauDoiTra = ?";
                                        $stmt = $conn->prepare($sqlCheck);
                                        $stmt->bind_param("s", $MaYeuCauDoiTra);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();

                                            // Kiểm tra nếu MaShipper không khớp với nhân viên đăng nhập
                                            if ($row['MaShipper'] !== $maShipperDangNhap) {
                                                $_SESSION['errorMessages'] = "Bạn không có quyền truy cập phiếu yêu cầu đổi trả này!";
                                                echo "<script>window.location.href='../view/nvvcPhanPhoiDonHang_DoiTra.php';</script>";
                                                exit();
                                            }
                                        } else {
                                            $_SESSION['errorMessages'] = "Phiếu yêu cầu đổi trả không tồn tại!";
                                            echo "<script>window.location.href='../view/nvvcPhanPhoiDonHang_DoiTra.php';</script>";
                                            exit();
                                        }
                                    } else {
                                        $_SESSION['errorMessages'] = "Thiếu thông tin mã phiếu yêu cầu đổi trả!";
                                        echo "<script>window.location.href='../view/nvvcPhanPhoiDonHang_DoiTra.php';</script>";
                                        exit();
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
                                        <button type="submit" name="delivery_confirm" id="delivery_confirm"
                                            class="btn btn-success btn-lg delivery_confirm" data-status="9">Đã xác
                                            nhận</button>
                                        <a href="./nvvcPhanPhoiDonHang_DoiTra.php" class="btn btn-secondary btn-lg"
                                            tabindex="-1" role="button" aria-disabled="true">Quay lại</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</main>
<script>
    $(document).ready(function () {
        // Khi bấm nút "Đã xác nhận"
        $('#delivery_confirm').click(function () {
            var status = $(this).data('status'); // Lấy trạng thái từ thuộc tính data
            var maPhieuXuat = '<?php echo $MaPhieuXuat; ?>'; // Mã phiếu xuất từ PHP
            var maYeuCauDoiTra = '<?php echo $MaYeuCauDoiTra; ?>';

            // Gửi yêu cầu AJAX với action cụ thể
            $.ajax({
                url: '../php/update_status_delivery_doitra.php',
                method: 'POST',
                data: {
                    action: 'delivery_confirm',
                    status: status,
                    maYeuCauDoiTra: maYeuCauDoiTra,
                    maPhieuXuat: maPhieuXuat
                },
                success: function (response) {
                    var data = JSON.parse(response);

                    // Hiển thị thông báo lên giao diện
                    $('.message_show').prepend(`
                            <div class="alert alert-${data.type} alert-dismissible fade show" role="alert">
                                <strong>Lưu ý!</strong> ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    $('#delivery_confirm').replaceWith(data.button);
                },
                error: function () {
                    alert('Có lỗi xảy ra. Vui lòng thử lại!');
                }
            });
        });
        $(document).on('click', '#pickup_confirm', function () {
            var status = $(this).data('status');
            var maPhieuXuat = '<?php echo $MaPhieuXuat; ?>'; // Mã phiếu xuất từ PHP
            var maYeuCauDoiTra = '<?php echo $MaYeuCauDoiTra; ?>';
            $.ajax({
                url: '../php/update_status_delivery_doitra.php',
                method: 'POST',
                data: {
                    action: 'pickup_confirm',
                    status: status,
                    maYeuCauDoiTra: maYeuCauDoiTra,
                    maPhieuXuat: maPhieuXuat

                },
                success: function (response) {
                    console.log(response); // Kiểm tra phản hồi từ server
                    try {
                        var data = JSON.parse(response);



                        // Hiển thị thông báo lên giao diện
                        $('.message_show').prepend(`
                            <div class="alert alert-${data.type} alert-dismissible fade show" role="alert">
                                <strong>Lưu ý!</strong> ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);

                        $('#pickup_confirm').replaceWith(data.button);
                    } catch (e) {
                        console.error('JSON Parse Error:', response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        $(document).on('click', '#complete_delivery', function () {
            var status = $(this).data('status');
            var maPhieuXuat = '<?php echo $MaPhieuXuat; ?>'; // Mã phiếu xuất từ PHP
            var maYeuCauDoiTra = '<?php echo $MaYeuCauDoiTra; ?>';
            var MaShipper = $(this).data('nhanviengiaohang');
            var TongTien = $(this).data('tongtien');

            $.ajax({
                url: '../php/update_status_delivery_doitra.php',
                method: 'POST',
                data: {
                    action: 'complete_delivery',
                    status: status,
                    maYeuCauDoiTra: maYeuCauDoiTra,
                    maPhieuXuat: maPhieuXuat,
                    MaShipper: MaShipper,
                    TongTien: TongTien
                },
                success: function (response) {
                    console.log(response); // Kiểm tra phản hồi từ server
                    try {
                        var data = JSON.parse(response);
                        if (data.success) {
                            window.location.href = '../view/nvvcPhanPhoiDonHang_DoiTra.php';
                        } else {
                            // Hiển thị thông báo lỗi từ server (nếu có)
                            alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại!');
                        }

                    } catch (e) {
                        console.error('JSON Parse Error:', response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        });
    });





</script>
</body>

</html>