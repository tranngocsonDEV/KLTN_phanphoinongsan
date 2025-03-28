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
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    // Database connection
                                    include("../php/connect.php");

                                    $maShipperDangNhap = isset($_SESSION['ThongTinDangNhap']['User_id']) ? $_SESSION['ThongTinDangNhap']['User_id'] : null;

                                    if (isset($_GET['MaPhieuXuat'])) {
                                        $MaPhieuXuat = $_GET['MaPhieuXuat'];

                                        // Truy vấn kiểm tra quyền truy cập
                                        $sqlCheck = "SELECT MaShipper FROM tbl_chitietphieuxuat WHERE MaPhieuXuat = ?";
                                        $stmt = $conn->prepare($sqlCheck);
                                        $stmt->bind_param("s", $MaPhieuXuat);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();

                                            // Kiểm tra nếu MaShipper không khớp với nhân viên đăng nhập
                                            if ($row['MaShipper'] !== $maShipperDangNhap) {
                                                $_SESSION['errorMessages'] = "Bạn không có quyền truy cập phiếu xuất này!";
                                                echo "<script>window.location.href='../view/nvvcPhanPhoiDonHang.php';</script>";
                                                exit();
                                            }
                                        } else {
                                            $_SESSION['errorMessages'] = "Phiếu xuất không tồn tại!";
                                            echo "<script>window.location.href='../view/nvvcPhanPhoiDonHang.php';</script>";
                                            exit();
                                        }
                                    } else {
                                        $_SESSION['errorMessages'] = "Thiếu thông tin mã phiếu xuất!";
                                        echo "<script>window.location.href='../view/nvvcPhanPhoiDonHang.php';</script>";
                                        exit();
                                    }
                                    // Thực hiện truy vấn và hiển thị thông tin chi tiết
                                    $sql = "SELECT DISTINCT tbl_phieuxuat.MaPhieuXuat AS MaPhieuXuatKho, lp.Ten AS Ten, nvk.IDNhanVien AS IDNhanVienKho,
                        u1.Ten AS NhanVienKho,NgayLapPhieu, NgayXuatHang, NgayGiaoHang, TongSoLoaiSanPham,
                        tbl_a_trangthaiphieuyeucau.Ten AS TenTrangThai ,GhiChu, kh.MaKhachHang AS MaKhachHang,
                        kh.Ten AS TenKhachHang, kh.DiaChi, kh.SoDienThoai, kh.Email, kh.NganhNgheKinhDoanh, ctpx.MaShipper, u2.Ten AS TenNhanVienGiaoHang
                        ,tt.TrangThaiThanhToan
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
                                            echo "<div class='row'>";
                                            echo "<div class='col-6'>";
                                            echo "<dl class='row'>";
                                            echo "<div class='mb-2'><strong>Mã phiếu:</strong> " . $row['MaPhieuXuatKho'] . "</div>";
                                            echo "<div class='mb-2'><strong>Tên phiếu:</strong> " . $row['Ten'] . "</div>";
                                            echo "<div class='mb-2'><strong>Người lập:</strong> " . $row['NhanVienKho'] . "</div>";
                                            echo "<div class='mb-2'><strong>Trạng thái:</strong> " . $row['TenTrangThai'] . "</div>";
                                            echo "<div class='mb-2'><strong>Ghi chú:</strong> " . $row['GhiChu'] . "</div>";
                                            echo "<div class='mb-2'><strong>Nhân viên giao hàng:</strong> " . $row['TenNhanVienGiaoHang'] . "</div>";
                                            echo "<div class='mb-2'><strong>Trạng thái thanh toán:</strong> " . $row['TrangThaiThanhToan'] . "</div>";
                                            echo "</dl>";
                                            echo "</div>";

                                            echo "<div class='col-6'>";
                                            echo "<dl class='row'>";

                                            echo "<div class='mb-2'><strong>Ngày lập phiếu:</strong> " . $row['NgayLapPhieu'] . "</div>";
                                            echo "<div class='mb-2'><strong>Ngày xuất hàng:</strong> " . $row['NgayXuatHang'] . "</div>";
                                            echo "<div class='mb-2'><strong>Ngày giao hàng:</strong> " . $row['NgayGiaoHang'] . "</div>";
                                            echo "<div class='mb-2'><strong>Mã KH:</strong> " . $row['MaKhachHang'] . "</div>";
                                            echo "<div class='mb-2'><strong>Tên khách hàng:</strong> " . $row['TenKhachHang'] . "</div>";
                                            echo "<div class='mb-2'><strong>Địa chỉ:</strong> " . $row['DiaChi'] . "</div>";
                                            echo "<div class='mb-2'><strong>Số điện thoại:</strong> " . $row['SoDienThoai'] . "</div>";
                                            echo "<div class='mb-2'><strong>Email:</strong> " . $row['Email'] . "</div>";
                                            echo "<div class='mb-2'><strong>Ngành nghề kinh doanh:</strong> " . $row['NganhNgheKinhDoanh'] . "</div>";
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
                                        <button type="submit" name="delivery_confirm" id="delivery_confirm"
                                            class="btn btn-success btn-lg delivery_confirm" data-status="9">Đã xác
                                            nhận</button>
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
<script>
    $(document).ready(function () {
        // Khi bấm nút "Đã xác nhận"
        $('#delivery_confirm').click(function () {
            var status = $(this).data('status'); // Lấy trạng thái từ thuộc tính data
            var maPhieuXuat = '<?php echo $MaPhieuXuat; ?>'; // Mã phiếu xuất từ PHP

            // Gửi yêu cầu AJAX với action cụ thể
            $.ajax({
                url: '../php/update_status_delivery.php',
                method: 'POST',
                data: {
                    action: 'delivery_confirm',
                    status: status,
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
            var maPhieuXuat = '<?php echo $MaPhieuXuat; ?>';

            $.ajax({
                url: '../php/update_status_delivery.php',
                method: 'POST',
                data: {
                    action: 'pickup_confirm',
                    status: status,
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
            var maPhieuXuat = '<?php echo $MaPhieuXuat; ?>';
            var MaShipper = $(this).data('nhanviengiaohang');
            var TongTien = $(this).data('tongtien');

            $.ajax({
                url: '../php/update_status_delivery.php',
                method: 'POST',
                data: {
                    action: 'complete_delivery',
                    status: status,
                    maPhieuXuat: maPhieuXuat,
                    MaShipper: MaShipper,
                    TongTien: TongTien
                },
                success: function (response) {
                    console.log(response); // Kiểm tra phản hồi từ server
                    try {
                        var data = JSON.parse(response);
                        if (data.success) {
                            window.location.href = '../view/nvvcPhanPhoiDonHang.php';
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