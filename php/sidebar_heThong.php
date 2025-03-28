<?php
ob_start();
include("../config/init.php");
if (isset($_SESSION["MaVaiTro"])) {
    $maVaiTro = $_SESSION["MaVaiTro"];
    ob_end_flush();

    ?>

    <div class="offcanvas offcanvas-start bg-dark text-white sidebar-nav" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <!-- Quản lý -->
                    <?php if ($maVaiTro == '1'): ?>

                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                TRANG CHỦ
                            </div>
                        </li>
                        <li>
                            <a href="../view/thongKe.php" class="nav-link px-3 active">
                                <span><i class="bi bi-speedometer2"></i></span>
                                <span>Thống kê</span>
                            </a>
                        </li>
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                YÊU CẦU
                            </div>
                        </li>

                        <li>
                            <a href="./phieuYeuCau.php" class="nav-link px-3">
                                <span><i class="bi bi-card-text"></i></span>
                                <span>Phiếu yêu cầu</span>
                            </a>
                        </li>
                        <li>
                            <a href="./yeuCau_ThanhLy.php" class="nav-link px-3">
                                <span><i class="bi bi-trash"></i></span>
                                <span>Thanh lý</span>
                            </a>
                        </li>
                        <li>
                            <a href="./yeuCau_DoiTra.php" class="nav-link px-3">
                                <span><i class="bi bi-shield-exclamation"></i></span>
                                <span>Yêu cầu đổi trả</span>
                            </a>
                        </li>
                        <!-- Biên bản kiểm kế-->
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                Biên bản kiểm kê
                            </div>
                        </li>
                        <li>
                            <a href="./phieuBienBan.php" class="nav-link px-3">
                                <span><i class="bi bi-exclamation-triangle-fill"></i></span>
                                <span>Biên bản kiểm kê</span>
                            </a>
                        </li>

                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                QUẢN LÝ
                            </div>
                        </li>
                        <li>
                            <a href="./xemThongTinKho.php" class="nav-link px-3">
                                <span><i class="bi bi-database"></i></span>
                                <span>Thông tin kho</span>
                            </a>
                        </li>
                        <li>
                            <a href="./phanPhoiDonHang.php" class="nav-link px-3">
                                <span><i class="bi bi-box-seam"></i></span>
                                <span>Phân phối</span>
                            </a>
                        </li>
                        <li>
                            <a href="./quanLyDonHang.php" class="nav-link px-3">
                                <span><i class="bi bi-basket"></i></span>
                                <span>Đơn hàng</span>
                            </a>
                        </li>
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                TÀI KHOẢN
                            </div>
                        </li>
                        <li>
                            <a href="./capTaiKhoan.php" class="nav-link px-3">
                                <span><i class="bi bi-person-add"></i></span>
                                <span>Quản lý tài khoản</span>
                            </a>
                        </li>
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                    <?php endif; ?>
                    <!-- Nhân viên kho -->
                    <?php if ($maVaiTro == '2'): ?>
                        <!-- Tạo phiếu nhập/xuất -->
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                YÊU CẦU
                            </div>
                        </li>
                        <li>
                            <a href="../view/nvPhieuYeuCau.php" class="nav-link px-3">
                                <span><i class="bi bi-card-text"></i></span>
                                <span>Tạo phiếu yêu cầu</span>
                            </a>
                        </li>
                        <li>
                            <a href="../view/nvYeuCauDoiTra.php" class="nav-link px-3">
                                <span><i class="bi bi-shield-exclamation"></i></span>
                                <span>Yêu cầu đổi trả</span>
                            </a>
                        </li>
                        <!--  -->
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                QUẢN LÝ
                            </div>
                        </li>
                        <li>
                            <a href="./nvQuanLyKho.php" class="nav-link px-3">
                                <span><i class="bi bi-database"></i></span>
                                <span>Sản phẩm</span>
                            </a>
                        </li>
                        <!--  -->
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                        <!--  Xác nhận nhập/xuất nông sản -->
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                CẬP NHẬT SỐ LƯỢNG
                            </div>
                        </li>
                        <li>
                            <a href="../view/nvCapNhatSoLuongNhap.php" class="nav-link px-3">
                                <span><i class="bi bi-box-arrow-right"></i></span>
                                <span>Nhập kho</span>
                            </a>
                        </li>
                        <li>
                            <a href="../view/nvCapNhatSoLuongXuat.php" class="nav-link px-3">
                                <span><i class="bi bi-box-arrow-left"></i></span>
                                <span>Xuất kho</span>
                            </a>
                        </li>
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                        <!-- Thêm mục quản lý bài viết -->
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                QUẢN LÝ BÀI VIẾT
                            </div>
                        </li>
                        <li>
                            <a href="../view/nvBaiVietTruyXuatNG.php" class="nav-link px-3">
                                <span><i class="bi bi-journal-text"></i></span>
                                <span>Quản lý bài viết</span>
                            </a>
                        </li>
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                        <!-- Tạo mã QR code-->
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                Mã QRCode
                            </div>
                        </li>
                        <li>
                            <a href="../view/nvTaoMaQRCode.php" class="nav-link px-3">
                                <span><i class="bi bi-qr-code-scan"></i></span>
                                <span>Tạo Mã QRCode</span>
                            </a>
                        </li>
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                    <?php endif; ?>
                    <!-- Nhân viên kiểm kê -->
                    <?php if ($maVaiTro == '3'): ?>
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                DANH SÁCH
                            </div>
                        </li>
                        <li>
                            <a href="../view/nvkkPhieuChoKiemTra.php" class="nav-link px-3">
                                <span><i class="bi bi-file-earmark-excel"></i></span>
                                <span>Chờ kiểm tra</span>
                            </a>
                        </li>
                        <li>
                            <a href="../view/nvkkXuLyDonHang.php" class="nav-link px-3">
                                <span><i class="bi bi-file-arrow-down-fill"></i></span>
                                <span>Xử lý đơn hàng</span>
                            </a>
                        </li>
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                        <!-- Tạo biên bản -->
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                BIÊN BẢN
                            </div>
                        </li>
                        <li>
                            <a href="../view/nvkkPhieuBienBan.php" class="nav-link px-3">
                                <span><i class="bi bi-file-earmark-excel"></i></span>
                                <span>Biên bản</span>
                            </a>
                        </li>
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                    <?php endif; ?>
                    <!-- Nhân viên giao hàng -->
                    <?php if ($maVaiTro == '4'): ?>
                        <!-- Nhận đơn hàng -->
                        <li>
                            <div class="text-muted small fw-bold text-uppercase px-3">
                                VẬN CHUYỂN
                            </div>
                        </li>
                        <li>
                            <a href="../view/nvvcPhanPhoiDonHang.php" class="nav-link px-3">
                                <span><i class="bi bi-box-seam"></i></span>
                                <span>Đơn hàng</span>
                            </a>
                        </li>
                        <li class="my-4">
                            <hr class="dropdown-divider" />
                        </li>
                    <?php endif; ?>



                </ul>
            </nav>
            <?php
            ob_start();
} else {
    // Chuyển hướng nếu chưa đăng nhập
    header("Location: login.php");
    exit;
}
ob_end_flush();

?>
    </div>
</div>